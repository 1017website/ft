<?php

namespace Tests\Feature;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class ErrorPageTest extends TestCase
{
    public static function statuses(): array
    {
        return array_map(fn ($status) => [$status], [400, 401, 403, 404, 405, 408, 410, 413, 418, 419, 422, 429, 500, 502, 503, 504, 507]);
    }

    #[DataProvider('statuses')]
    public function test_html_errors_use_safe_pages_and_preserve_status_and_headers(int $status): void
    {
        config(['app.debug' => true]);
        DB::listen(fn () => throw new \RuntimeException('Error pages must not query the database.'));
        $request = Request::create('/missing', 'GET', server: ['HTTP_ACCEPT' => 'text/html']);
        $response = app(ExceptionHandler::class)->render($request, new HttpException($status, 'PRIVATE_EXCEPTION_DETAIL', null, ['Retry-After' => '60']));

        $this->assertSame($status, $response->getStatusCode());
        $this->assertSame('60', $response->headers->get('Retry-After'));
        $this->assertStringContainsString('Kembali ke beranda', $response->getContent());
        $this->assertStringNotContainsString('PRIVATE_EXCEPTION_DETAIL', $response->getContent());
        $this->assertStringNotContainsString('Exception trace', $response->getContent());
    }

    public function test_database_failure_is_hidden_even_with_debug_enabled(): void
    {
        config(['app.debug' => true]);
        $exception = new QueryException('mysql', 'select * from secret_users', [], new \PDOException('Too many connections'));
        $response = app(ExceptionHandler::class)->render(Request::create('/admin'), $exception);

        $this->assertSame(500, $response->getStatusCode());
        $this->assertStringContainsString('Terjadi gangguan pada server.', $response->getContent());
        $this->assertStringNotContainsString('secret_users', $response->getContent());
        $this->assertStringNotContainsString('Too many connections', $response->getContent());
    }

    public function test_json_error_stays_json(): void
    {
        config(['app.debug' => false]);
        $request = Request::create('/api/missing', 'GET', server: ['HTTP_ACCEPT' => 'application/json']);
        $response = app(ExceptionHandler::class)->render($request, new HttpException(404, 'Not found'));

        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertSame('Not found', json_decode($response->getContent(), true)['message']);
    }

    public function test_missing_route_uses_custom_error_page_in_production_mode(): void
    {
        config(['app.debug' => false]);
        $this->get('/this-page-does-not-exist')->assertNotFound()->assertSee('Halaman tidak ditemukan.');
    }
}
