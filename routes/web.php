<?php

use App\Livewire\CreateServer;
use App\Livewire\ShowServer;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/server/create', CreateServer::class)
    ->middleware(['auth', 'verified'])
    ->name('server.create');

Route::get('/server/{server}', ShowServer::class)
    ->middleware(['auth', 'verified'])
    ->name('server.show');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
