<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\Console\Output\BufferedOutput;
use Throwable;

class DeveloperController extends Controller
{
    public const COMMANDS = [
        'migrate' => 'Menjalankan migrasi database yang belum diterapkan.',
        'optimize:clear' => 'Membersihkan cache konfigurasi, route, view, dan aplikasi.',
        'storage:link' => 'Membuat tautan public/storage untuk file yang diunggah.',
    ];

    public function index()
    {
        return view('admin.developer', ['commands' => self::COMMANDS]);
    }

    public function run(Request $request)
    {
        $data = $request->validate(['command' => ['required', Rule::in(array_keys(self::COMMANDS))]]);
        $command = $data['command'];
        $output = new BufferedOutput;
        try {
            $exitCode = Artisan::call($command, $command === 'migrate' ? ['--force' => true, '--no-interaction' => true] : ['--no-interaction' => true], $output);
        } catch (Throwable $exception) {
            report($exception);
            $exitCode = 1;
            $output->writeln('Perintah gagal. Periksa log aplikasi untuk rincian kesalahan.');
        }
        $text = $output->fetch();
        // Laravel storage:link may print an error while returning exit code zero.
        $successful = $exitCode === 0 && ! preg_match('/^\s*ERROR\s/m', $text);
        Log::notice('Developer ran Artisan command', ['user_id' => $request->user()->id, 'command' => $command, 'exit_code' => $exitCode, 'successful' => $successful]);

        return redirect()->route('admin.developer.index')->with('command_result', [
            'command' => $command,
            'successful' => $successful,
            'output' => Str::limit($text, 12000),
        ]);
    }
}
