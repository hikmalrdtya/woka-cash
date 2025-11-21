<?php

use Illuminate\Support\Facades\Route;

Route::get('/', action: function () {
    return view('index');
});
