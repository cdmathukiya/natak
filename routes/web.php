<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeamAvailableController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('a_teams')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('teams');
        Route::get('create', [TeamController::class, 'create'])->name('team.create');
        Route::post('save', [TeamController::class, 'save'])->name('team.save');
        Route::get('{team}/edit', [TeamController::class, 'edit'])->name('team.edit');
        Route::get('{team}/show', [TeamController::class, 'show'])->name('team.show');
        Route::put('{team}/update', [TeamController::class, 'update'])->name('team.update');
        Route::delete('{team}/delete', [TeamController::class, 'delete'])->name('team.delete');
    });

    Route::prefix('a_team_available')->group(function () {
        Route::get('/', [TeamAvailableController::class, 'index'])->name('team_availables');
        Route::get('create', [TeamAvailableController::class, 'create'])->name('team_available.create');
        Route::post('save', [TeamAvailableController::class, 'save'])->name('team_available.save');
        Route::get('{teamAvailable}/edit', [TeamAvailableController::class, 'edit'])->name('team_available.edit');
        Route::get('{teamAvailable}/show', [TeamAvailableController::class, 'show'])->name('team_available.show');
        Route::put('{teamAvailable}/update', [TeamAvailableController::class, 'update'])->name('team_available.update');
        Route::delete('{teamAvailable}/delete', [TeamAvailableController::class, 'delete'])->name('team_available.delete');
        route::get('get-team-details', [TeamAvailableController::class, 'getTeamDetails'])->name('get_team_details');
        route::post('save/spots-item', [TeamAvailableController::class, 'spotsItemSave'])->name('team_available.spots_item.save');
    });

    Route::prefix('a_report')->group(function () {
        Route::get('team_report', [ReportController::class, 'teamReport'])->name('teamReport');
    });

    Route::prefix('a_users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::post('save', [UserController::class, 'save'])->name('user.save');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('{user}/update', [UserController::class, 'update'])->name('user.update');
        Route::delete('{user}/delete', [UserController::class, 'delete'])->name('user.delete');
    });
});
require __DIR__.'/auth.php';
