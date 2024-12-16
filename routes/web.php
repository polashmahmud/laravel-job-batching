<?php

use App\Jobs\Server\CreateServer;
use App\Jobs\Server\FinalizeServer;
use App\Jobs\Server\InstallNginx;
use App\Jobs\Server\InstallPHP;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/job', function () {
    \Illuminate\Support\Facades\Bus::batch([
        new CreateServer(),
        new InstallNginx(),
        new InstallPHP(),
        new FinalizeServer()
    ])
    ->dispatch();
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
