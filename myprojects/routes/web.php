<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\DepartmentController;
use App\Models\Software;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'home');

Route::resource('departments', DepartmentController::class);

Route::controller(SoftwareController::class)
    ->prefix('softwares')
    ->name('softwares.')
    ->group(function () {

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
    });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');

Route::get('/department/dashboard', function () {
    return view('department.dashboard');
})->middleware('auth')->name('department.dashboard');

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware('auth')->name('user.dashboard');