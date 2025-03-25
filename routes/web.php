<?php

use App\Http\Controllers\CatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('index');
});
Route::resource('cats', CatController::class);
