<?php

use Doker42\VisitorsWatcher\Http\Controllers\IgnoredIpController;
use Doker42\VisitorsWatcher\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth'])->group(function () {

    Route::group(['prefix' => 'visitors'], function () {
        Route::controller( VisitorController::class)->group(function () {
            Route::get('/', 'index')->name('visitors.visitor.list');
            Route::post('/ban-update', 'banUpdate')->name('visitors.visitor.ban_update');
        });
    });
    Route::group(['prefix' => 'ignored-ips'], function () {
        Route::controller( IgnoredIpController::class)->group(function () {
            Route::get('/list', 'index')->name('visitors.ignored_ip.list');
            Route::get('/create', 'create')->name('visitors.ignored_ip.create');
            Route::post('/store', 'store')->name('visitors.ignored_ip.store');
            Route::delete('/delete/{ip}', 'destroy')->name('visitors.ignored_ip.destroy');
        });
    });

});

