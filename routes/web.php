<?php

use App\Http\Controllers\ScheduleCalendarController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\RedirectBasedOnRole;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    $user = Auth::user();
    $role = $user->role->name; 

    return redirect()->route($role);
})
->middleware(['auth', 'verified'])
->name('dashboard');

Route::view('student', 'student-dashboard')
    ->middleware(['auth', 'verified'])
    ->name('student')
    ->middleware(RedirectBasedOnRole::class);

use App\Http\Controllers\ScheduleController;

// Ruta principal del panel del tutor
Route::view('tutor', 'tutor-dashboard')
    ->middleware(['auth', 'verified', RedirectBasedOnRole::class])
    ->name('tutor');

// Agrupar rutas bajo autenticación y verificación
Route::middleware(['auth', 'verified'])->group(function () {

    // CRUD de horarios para el tutor autenticado
    Route::prefix('tutor/schedules')->name('tutor.schedules.')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('index');
        Route::get('/edit/{schedule}', [ScheduleController::class, 'edit'])->name('edit');
        // Ruta para ver todas las solicitudes de un schedule específico
        Route::get('requests/{schedule}', function (\App\Models\Schedule $schedule) {
            return view('tutor.requests.index', compact('schedule'));
        })->name('requests');
        Route::post('/', [ScheduleController::class, 'store'])->name('store');
        Route::put('/{schedule}', [ScheduleController::class, 'update'])->name('update');
        Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
    });
});


Route::view('coordinator', 'coordinator-dashboard')
    ->middleware(['auth', 'verified'])
    ->name('coordinator')
    ->middleware(RedirectBasedOnRole::class);
    
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';