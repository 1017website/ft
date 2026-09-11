@php
    $dot = str_replace(['][', '[', ']'], ['.', '.', ''], $name);
    $value = old($dot, $value ?? '');
    $id = 'input-'.str_replace(['[',']'], ['-',''], $name);
    $fieldLabel = explode(' — ', $field['label'])[0];
    $fieldLabel = str_starts_with($name, 'fields[') ? config('admin.labels.'.($section ?? '').'.'.$key, $fieldLabel) : $fieldLabel;
    $hasError = $errors->has($dot) || $errors->has('uploads.'.$dot);
@endphp
<div @class(['field', 'field-wide' => in_array($field['type'], ['image', 'textarea']), 'has-error' => $hasError])>
    <label for="{{ $id }}">{{ $fieldLabel }}</label>
    @if($field['type'] === 'image')
        <div class="image-field" data-upload>
            <div class="upload-preview" @if(!$value) hidden @endif data-preview-wrap><img class="image-preview" @if($value) src="{{ asset($value) }}" @else hidden @endif data-original="{{ $value ? asset($value) : '' }}" alt="Preview gambar"><span class="preview-badge" data-preview-badge>Gambar saat ini</span></div>
            <div class="upload-zone" data-dropzone>
                <span class="upload-icon">@include('admin.icon', ['icon' => 'upload'])</span>
                <strong>Tarik gambar ke sini</strong><span class="upload-or">atau pilih dari perangkat Anda</span>
                <div class="file-picker"><input id="{{ $id }}" type="file" name="uploads[{{ preg_replace('/\[/', '][', $name, 1) }}" accept="image/jpeg,image/png,image/webp" data-image-input aria-describedby="{{ $id }}-hint {{ $id }}-error"><span class="secondary" aria-hidden="true">Pilih gambar</span></div>
                <small id="{{ $id }}-hint">JPG, PNG, WebP · Maks. 5 MB</small>
            </div>
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            <div class="upload-info"><span data-file-info>{{ $value ? 'Gambar tersimpan. Pilih file untuk menggantinya.' : 'Belum ada gambar yang dipilih.' }}</span><button class="quiet" type="button" data-upload-reset hidden>Batalkan</button></div>
            <p id="{{ $id }}-error" class="upload-error" data-upload-error role="alert" hidden></p>
        </div>
    @elseif($field['type'] === 'select')
        <select id="{{ $id }}" name="{{ $name }}">@foreach($field['options'] as $option => $label)<option value="{{ $option }}" @selected((string)$value === (string)$option)>{{ $label }}</option>@endforeach</select>
    @elseif($field['type'] === 'textarea')
        <textarea id="{{ $id }}" name="{{ $name }}" rows="3" maxlength="5000" @if($hasError) aria-invalid="true" @endif>{{ $value }}</textarea>
        @if(str_contains($fieldLabel, 'Enter'))<small>Pemisah baris akan mengikuti susunan judul di website.</small>@endif
    @else
        <input id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
            type="{{ in_array($field['type'], ['latitude','longitude','number']) ? 'number' : (in_array($field['type'], ['url','email']) ? $field['type'] : 'text') }}"
            @if($field['type'] === 'number') min="{{ $field['min'] ?? 0 }}" max="{{ $field['max'] ?? 100 }}" step="1" required @endif
            @if(in_array($field['type'], ['latitude','longitude'])) step="any" min="{{ $field['type'] === 'latitude' ? -90 : -180 }}" max="{{ $field['type'] === 'latitude' ? 90 : 180 }}" required @endif
            @if($hasError) aria-invalid="true" @endif
            maxlength="{{ $field['type'] === 'url' ? 2048 : 5000 }}">
    @endif
    @if(!empty($field['hint']))<small>{{ $field['hint'] }}</small>@endif
    @error($dot)<span class="field-error">{{ $message }}</span>@enderror
    @error('uploads.'.$dot)<span class="field-error">{{ $message }}</span>@enderror
</div>
