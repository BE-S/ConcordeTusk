<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\SensorController;
use \App\Http\Controllers\Api\SensorMeasurementsController;

Route::get("/", [SensorController::class, "index"])->name("set.api.sensor");
Route::get("/get/", [SensorMeasurementsController::class, "index"])->name("get.api.sensor");
