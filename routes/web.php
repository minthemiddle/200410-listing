<?php

use Illuminate\Support\Facades\Route;

Route::post('/{user}/profile/update', 'UserController@update')->name('user.profile.update')->middleware('can:update,user');
