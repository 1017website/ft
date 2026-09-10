<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ContentController extends Controller
{
    public function edit(string $section)
    {
        $definition = config('cms.'.$section);
        abort_unless($definition, 404);
        $record = SiteSection::find($section);

        return view('admin.edit', [
            'section' => $section, 'definition' => $definition,
            'data' => $record?->content ?? $definition['defaults'],
            'version' => $record?->version() ?? '',
        ]);
    }

    public function update(Request $request, string $section)
    {
        $definition = config('cms.'.$section);
        abort_unless($definition, 404);
        $record = SiteSection::find($section);
        if ($request->input('version', '') !== ($record?->version() ?? '')) {
            throw ValidationException::withMessages(['version' => 'Konten sudah berubah di tab lain. Muat ulang halaman sebelum menyimpan.']);
        }
        $rules = ['fields' => 'nullable|array', 'groups' => 'nullable|array'];
        $labels = [];
        $addRules = function ($fields, $prefix) use (&$rules, &$labels) {
            foreach ($fields as $key => $field) {
                $path = $prefix.'.'.$key;
                $rules[$path] = match ($field['type']) {
                    'image' => ['required_without:uploads.'.$path, 'nullable', 'string', 'regex:~^(assets/ft/images/[a-zA-Z0-9._-]+|storage/cms/[a-zA-Z0-9._-]+)$~'],
                    'latitude' => 'required|numeric|between:-90,90',
                    'longitude' => 'required|numeric|between:-180,180',
                    'url' => ['nullable', 'url:http,https', 'max:2048'],
                    default => 'nullable|string|max:5000',
                };
                $labels[$path] = $field['label'];
                if ($field['type'] === 'image') {
                    $rules['uploads.'.$path] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120';
                    $labels['uploads.'.$path] = $field['label'];
                }
            }
        };
        $addRules($definition['fields'], 'fields');
        foreach ($definition['groups'] as $key => $group) {
            $rules['groups.'.$key] = 'nullable|array|max:40';
            $addRules($group['fields'], 'groups.'.$key.'.*');
        }
        $validated = Validator::make($request->all(), $rules, [
            'max' => ':attribute melewati batas yang diizinkan (:max).',
            'image' => ':attribute harus berupa gambar.',
            'required_without' => 'Pilih :attribute untuk item baru.',
            'mimes' => ':attribute harus JPG, PNG, atau WebP.',
            'between' => ':attribute harus antara :min dan :max.',
            'url' => ':attribute harus berupa alamat http:// atau https:// yang valid.',
        ], $labels)->validate();
        $created = [];
        $collect = function ($fields, $prefix) use ($request, $validated, &$created) {
            $result = [];
            foreach ($fields as $key => $field) {
                $path = $prefix.'.'.$key;
                $result[$key] = data_get($validated, $path) ?? '';
                if ($field['type'] === 'image' && $request->hasFile('uploads.'.$path)) {
                    $stored = $request->file('uploads.'.$path)->store('cms', 'public');
                    $created[] = $stored;
                    $result[$key] = 'storage/'.$stored;
                }
            }

            return $result;
        };
        try {
            $content = ['fields' => $collect($definition['fields'], 'fields'), 'groups' => []];
            foreach ($definition['groups'] as $key => $group) {
                foreach (array_keys($validated['groups'][$key] ?? []) as $index) {
                    $content['groups'][$key][] = $collect($group['fields'], 'groups.'.$key.'.'.$index);
                }
                $content['groups'][$key] ??= [];
            }
            SiteSection::updateOrCreate(['key' => $section], ['content' => $content]);
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($created);
            throw $exception;
        }

        return redirect()->route('admin.edit', $section)->with('success', 'Perubahan disimpan dan sudah tampil di website.');
    }
}
