<?php

use App\Http\Controllers\ScheduleCalendarController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Middleware\RedirectBasedOnRole;
use App\Http\Controllers\ScheduleController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    $user = Auth::user();
    $role = $user->role->name;

    if ($role === 'student') {
        return redirect('/student'); // Panel Filament estudiantes
    }

    if ($role === 'coordinator') {
        return redirect('/coordinator'); // Panel Filament coordinador
    }

    // Opcional: para otros roles o default, redirigir a home o logout
    return redirect('/home');
})->middleware(['auth', 'verified'])->name('dashboard');


// Eliminada la ruta manual de 'student' que apuntaba a una vista.
// El panel de Filament debe manejar /student con sus propios middleware.

// Ruta principal del panel del tutor
Route::view('tutor', 'tutor-dashboard')
    ->middleware(['auth', 'verified', RedirectBasedOnRole::class])
    ->name('tutor');

// Agrupar rutas bajo autenticación y verificación para tutor schedules
Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('tutor/schedules')->name('tutor.schedules.')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('index');
        Route::get('/edit/{schedule}', [ScheduleController::class, 'edit'])->name('edit');
        Route::get('requests/{schedule}', function (\App\Models\Schedule $schedule) {
            return view('tutor.requests.index', compact('schedule'));
        })->name('requests');
        Route::post('/', [ScheduleController::class, 'store'])->name('store');
        Route::put('/{schedule}', [ScheduleController::class, 'update'])->name('update');
        Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
    });
});


    
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
