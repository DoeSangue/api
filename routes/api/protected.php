<?php

Route::group(['namespace' => 'User'], function () {
    Route::get('me', 'MeController@show');
});
