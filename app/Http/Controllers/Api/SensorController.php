<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SensorRequest;
use App\Jobs\SensorJob;
use App\Models\Api\Sensor;
use Illuminate\Support\Facades\Log;

class SensorController extends Controller
{
    public function index(SensorRequest $request)
    {
        try {
            $sensorId = $request->get("sensor");
            $measurements = $request->get("measurements");

            $key = array_key_first($measurements);
            $value = $measurements[$key];

            $sensor = Sensor::where("id", $sensorId)->whereAnd("param_name", $key)->first();

            if ($sensor) {
                SensorJob::dispatch($sensor, $value);
            } else {
                Log::info("Can't add new data in table SensorMeasurements. Not Found sensor where id = $sensorId. Try add value: $value. " . __FILE__);
            }

            return response()->json([
                "status" => true
            ]);
        } catch (\Throwable $exception) {
            Log::critical($exception->getMessage() . ". " . __FILE__);

            return response([
                "status" => false,
                "error"  => $exception->getMessage()
            ], 500);
        }
    }
}
