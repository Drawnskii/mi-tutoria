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

Route::view('tutor', 'tutor-dashboard')
    ->middleware(['auth', 'verified'])
    ->name('tutor')
    ->middleware(RedirectBasedOnRole::class);

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
