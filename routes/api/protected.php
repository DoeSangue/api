<?php

use Illuminate\Http\Request;

# USER
Route::group(['prefix' => 'user'], function () {
    # /user/
    Route::get(null, function (Request $request) {
        return $request->user();
    });
});
