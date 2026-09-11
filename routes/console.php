<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('cms:admin {email} {--name=Administrator FT}', function () {
    $email = $this->argument('email');
    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->error('Alamat email tidak valid.');

        return 1;
    }
    if (User::where('email', $email)->exists()) {
        $this->error('Email sudah terdaftar. Akun yang ada tidak diubah.');

        return 1;
    }
    $password = Str::password(20, symbols: false);
    $user = new User(['name' => $this->option('name'), 'email' => $email, 'password' => Hash::make($password)]);
    $user->is_admin = true;
    $user->save();
    $this->info('Admin dibuat: '.$email);
    $this->line('Kata sandi awal: '.$password);
    $this->line('Simpan kata sandi ini lalu ganti melalui menu Akun.');
})->purpose('Membuat akun admin CMS tanpa mengubah akun yang sudah ada');

Artisan::command('cms:serve {--port=8000}', function () {
    $port = filter_var($this->option('port'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1024, 'max_range' => 65535]]);
    if (! $port) {
        $this->error('Port harus antara 1024 dan 65535.');

        return 1;
    }
    $this->info('Website: http://127.0.0.1:'.$port.' | CMS: http://127.0.0.1:'.$port.'/admin');
    $process = new Process([
        PHP_BINARY, '-d', 'upload_max_filesize=5M', '-d', 'post_max_size=64M',
        '-d', 'max_file_uploads=100', '-d', 'max_input_vars=10000', '-S', '127.0.0.1:'.$port,
        base_path('vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php'),
    ], public_path());
    $process->setTimeout(null);

    return $process->run(fn ($type, $buffer) => $this->output->write($buffer));
})->purpose('Menjalankan website lokal dengan dukungan upload CMS 5 MB');
