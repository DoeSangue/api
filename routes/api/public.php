<?php

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('login', 'LoginController@login')->name('auth.login');
    Route::post('register', 'RegisterController@register')->name('auth.register');
});
