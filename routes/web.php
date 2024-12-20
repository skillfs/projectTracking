<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::view('/', 'home');

Route::resource('departments', DepartmentController::class);

Route::controller(SoftwareController::class)
    ->prefix('softwares')
    ->name('softwares.')
    ->group(function () {
        Route::get('/list', 'listRequests')
            ->name('list')
            ->middleware('auth'); // Protect this route with auth middleware

        Route::get('/dh-approvals', 'listRequests')
            ->name('dhApprovals')
            ->middleware('auth');

        Route::get('/admin-approvals', 'listRequests')
            ->name('adminApprovals')
            ->middleware('auth');

        Route::get('/my-requests', 'listRequests')
            ->name('myRequests')
            ->middleware('auth');

        Route::get('/', 'index')
            ->name('index');

        Route::get('/create', 'create')
            ->name('create');

        Route::post('/store', 'store')
            ->name('store');

        Route::get('/{software}', 'show')
            ->name('show')
            ->whereNumber('id');

        Route::get('/{software}/edit', 'edit')
            ->name('edit');

        Route::patch('/{software}', 'update')
            ->name('update');

        Route::delete('/{software}', 'destroy')
            ->name('destroy');

        // New route for listing software requests based on user roles
    });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
