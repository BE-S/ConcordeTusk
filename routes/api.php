<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\SensorController;
use \App\Http\Controllers\Api\SensorMeasurementsController;
use \App\Http\Controllers\Api\CreateNewAppController;

Route::get("/", [SensorController::class, "index"])->name("set.api.sensor")->middleware('web');
Route::get("/get/", [SensorMeasurementsController::class, "index"])->name("get.api.sensor")->middleware('web');

Route::get("/create-token/", [CreateNewAppController::class, "index"])->middleware('web');
