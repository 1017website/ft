<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuotationController;
use App\Http\Middleware\RequireAdmin;
use App\Models\QuotationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::post('/quotation', [QuotationController::class, 'store'])->middleware('throttle:5,1')->name('quotation.store');

Route::middleware('guest')->group(function () {
    Route::view('/admin/login', 'admin.login')->name('login');
    Route::post('/admin/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('admin.login');
});
Route::prefix('admin')->name('admin.')->middleware(['auth', RequireAdmin::class])->group(function () {
    Route::get('/', fn () => view('admin.index', [
        'websiteContent' => \App\Models\SiteSection::websiteContent(),
        'newRequests' => QuotationRequest::where('status', 'baru')->count(),
        'updates' => \App\Models\SiteSection::all()->keyBy('key'),
    ]))->name('index');
    Route::get('/content/{section}', [ContentController::class, 'edit'])->name('edit');
    Route::put('/content/{section}', [ContentController::class, 'update'])->name('update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::view('/account', 'admin.account')->name('account');
    Route::put('/account', [AuthController::class, 'password'])->name('password');
    Route::get('/requests', fn () => view('admin.requests', ['requests' => QuotationRequest::latest()->paginate(20)]))->name('requests');
    Route::patch('/requests/{quotation}', function (Request $request, QuotationRequest $quotation) {
        $quotation->update($request->validate(['status' => 'required|in:baru,diproses,selesai']));

        return back()->with('success', 'Status permintaan diperbarui.');
    })->name('requests.update');
});
