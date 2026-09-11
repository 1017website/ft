<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuotationController;
use App\Http\Middleware\RequireAdmin;
use App\Models\QuotationRequest;
use App\Models\SiteSection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/robots.txt', function () {
    $seo = SiteSection::websiteContent()['settings']['fields'];
    $rules = str_starts_with($seo['robots'], 'noindex') ? "Disallow: /\n" : "Disallow: /admin\n";

    return response("User-agent: *\n".$rules.'Sitemap: '.url('/sitemap.xml')."\n")->header('Content-Type', 'text/plain');
});
Route::get('/sitemap.xml', function () {
    $seo = SiteSection::websiteContent()['settings']['fields'];
    $location = htmlspecialchars($seo['canonical'] ?: route('home'), ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $lastmod = SiteSection::max('updated_at');
    $entry = str_starts_with($seo['robots'], 'noindex') ? '' : '<url><loc>'.$location.'</loc>'.($lastmod ? '<lastmod>'.Carbon::parse($lastmod)->toAtomString().'</lastmod>' : '').'</url>';

    return response('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$entry.'</urlset>')->header('Content-Type', 'application/xml');
});
Route::post('/quotation', [QuotationController::class, 'store'])->middleware('throttle:5,1')->name('quotation.store');

Route::middleware('guest')->group(function () {
    Route::view('/admin/login', 'admin.login')->name('login');
    Route::post('/admin/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('admin.login');
});
Route::prefix('admin')->name('admin.')->middleware(['auth', RequireAdmin::class])->group(function () {
    Route::get('/', fn () => view('admin.index', [
        'websiteContent' => SiteSection::websiteContent(),
        'newRequests' => QuotationRequest::where('status', 'baru')->count(),
        'updates' => SiteSection::all()->keyBy('key'),
    ]))->name('index');
    Route::get('/content/{section}', [ContentController::class, 'edit'])->name('edit');
    Route::put('/content/{section}', [ContentController::class, 'update'])->name('update');
    Route::post('/preview/{section}', [ContentController::class, 'preview'])->name('preview');
    Route::get('/statistics', StatisticsController::class)->name('statistics');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::view('/account', 'admin.account')->name('account');
    Route::put('/account', [AuthController::class, 'password'])->name('password');
    Route::get('/requests', fn () => view('admin.requests', ['requests' => QuotationRequest::latest()->paginate(20)]))->name('requests');
    Route::patch('/requests/{quotation}', function (Request $request, QuotationRequest $quotation) {
        $quotation->update($request->validate(['status' => 'required|in:baru,diproses,selesai']));

        return back()->with('success', 'Status permintaan diperbarui.');
    })->name('requests.update');
});
