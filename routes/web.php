<?php

use App\Http\Controllers\CatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('cats.index');
});
Route::resource('cats', CatController::class);
