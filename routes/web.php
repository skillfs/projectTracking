<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TimelineController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::view('/', 'home');

Route::resource('departments', DepartmentController::class);

Route::prefix('softwares')->group(function () {
    // Timelines routes first (more specific)
    Route::get('/{software}/timelines/edit', [TimelineController::class, 'edit'])
        ->name('timelines.edit')
        ->middleware('auth');

    Route::post('/{software}/timelines', [TimelineController::class, 'store'])
        ->name('timelines.store');

    Route::post('/{software}/duration', [TimelineController::class, 'storeDuration'])
        ->name('timelines.duration');

    Route::controller(SoftwareController::class)
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

            Route::put('/{software}/update-duration', 'updateDuration')
                ->name('updateDuration');

            Route::delete('/{software}', 'destroy')
                ->name('destroy');

            // New route for listing software requests based on user roles
        });
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin only route to manage timelines
Route::patch('/timelines/{timeline}', [TimelineController::class, 'update'])->name('timelines.update');
Route::get('/timelines/{timeline}/edit', [TimelineController::class, 'editTimeline'])->name('timelines.editTimeline');
Route::delete('/timelines/{timeline}', [TimelineController::class, 'destroy'])->name('timelines.destroy');
