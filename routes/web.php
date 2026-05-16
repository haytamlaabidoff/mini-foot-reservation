<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AdminController;

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationPdfController;
use App\Http\Controllers\PaymentStaffController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WorkingHourController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TerrainController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\SportFormatController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\PaymentcardController;

Route::middleware(['auth'])->group(function () {

Route::get('/home', [HomeController::class, 'index'])->middleware('auth');
    // dashboard
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');

    // bookings
    Route::get('/booking/{id}', [ReservationController::class, 'create'])
        ->name('booking.create');

    Route::post('/booking', [ReservationController::class, 'store'])
        ->name('booking.store');

    Route::get('/my-reservations', [ReservationController::class, 'index'])
        ->name('reservations.index');

    Route::patch('/reservation/{id}/cancel', [ReservationController::class, 'cancel'])
        ->name('reservation.cancel');

    // PDF
    Route::get('/reservation/{id}/pdf', [ReservationPdfController::class, 'show'])
        ->name('reservation.pdf');

    // payments
    Route::get('/payments', [PaymentStaffController::class, 'index'])
        ->name('payments.index');

    Route::get('/payments/create/{staff}', [PaymentStaffController::class, 'create'])
        ->name('payments.create');

    Route::post('/payments', [PaymentStaffController::class, 'store'])
        ->name('payments.store');

    Route::post('/payments/{id}/pay', [PaymentStaffController::class, 'pay'])
        ->name('payments.pay');

    // terrain hours (IMPORTANT FIX)
    Route::get('/terrain/{id}/hours', [ReservationController::class, 'getHours']);
            Route::resource('working-hours', WorkingHourController::class);
        Route::resource('staff', StaffController::class);
        Route::get('/', [AdminController::class, 'index']);

        Route::get('/create', [AdminController::class, 'create']);
        Route::post('/store', [AdminController::class, 'store']);

        Route::get('/settings', [GeneralSettingController::class, 'index']);
        Route::post('/settings', [GeneralSettingController::class, 'store']);

        // resources
        Route::resource('departments', DepartmentController::class);
        Route::resource('posts', PostController::class);

        // admin terrain hours (OPTIONAL BUT CLEAN)
        Route::get('/terrain/{id}/hours', [ReservationController::class, 'getHours']);

        Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);
Route::resource('terrains',TerrainController::class);


Route::patch('/terrains/{terrain}/toggle-condition', [TerrainController::class, 'toggleCondition'])
    ->name('terrains.toggleCondition');

Route::resource('sports', SportController::class);
Route::resource('sport-formats', SportFormatController::class);
Route::get('/sport-formats/{sport}', function ($sportId) {

    return \App\Models\SportFormat::where('sport_id', $sportId)
        ->get(['id', 'name', 'players_count']); });
Route::get('/sport-formats/{sport}', function ($sportId) {

    return \App\Models\SportFormat::where('sport_id', $sportId)
        ->get(['id', 'name', 'players_count']);

});
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard');
    // ✅ CRUD ADMIN
Route::patch('/admin/reservation/{id}/payment', [AdminController::class, 'togglePayment'])
    ->name('admin.reservation.payment');

Route::get('/scanner', function () {
    return view('scanner.index');
})->name('scanner.index');

Route::get('/verify-payment/{token}', [ReservationController::class, 'verifyPayment'])
    ->name('verify.payment');
Route::get('/payment/paid/{token}', [ReservationController::class, 'paidView'])
    ->name('payment.paid');
Route::get('/payment/unpaid/{token}',
    [ReservationController::class, 'unpaidView']
)->name('payment.unpaid');

    
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/sport-formats/{id}', function ($id) {return \App\Models\SportFormat::where('sport_id', $id)->get();});

Route::get('/terrain/{id}/hours', [HomeController::class, 'getHours']);


    Route::get('/payment/checkout/{reservation}',
        [PaymentController::class, 'checkout']
    )->name('payment.checkout');

    Route::post('/payment/session/{reservation}',
        [PaymentController::class, 'session']
    )->name('payment.session');

  Route::get('/payment/success',
    [PaymentController::class, 'success']
)->name('payment.success');

Route::get('/payment/cancel',
    [PaymentController::class, 'cancel']
)->name('payment.cancel');
use App\Http\Controllers\StaffPermissionController;

Route::middleware(['auth'])->group(function () {

    Route::get('/permissions/{user}', [StaffPermissionController::class, 'index'])
        ->name('permissions.index');

    Route::post('/permissions/{user}', [StaffPermissionController::class, 'store'])
        ->name('permissions.store');

});
use App\Http\Controllers\MaterialController;

Route::resource('materials', MaterialController::class);
Route::get('/departments/{id}/posts', function ($id) {

    return \App\Models\Post::where(
        'department_id',
        $id
    )->get();

});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY ROUTES
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| PUBLIC TERRAIN
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| AUTH FILE
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';