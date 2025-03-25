<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SensorRequest;
use App\Models\Api\Sensor;
use App\Models\Api\SensorMeasurements;

class SensorController extends Controller
{
    public function index(SensorRequest $request)
    {
        try {
            $sensorId = $request->get("sensor");

            $sensor = Sensor::find($sensorId);

            if (!$sensor) {
                return response()->json([
                    "status" => false,
                    "message" => "Sensor not found"
                ], 422);
            }

            $sensorParamName = $sensor->param_name ?? "";

            parse_str(
                $request->getContent(), $params
            );

            if (!isset($params[$sensorParamName])) {
                return response()->json([
                    "status"  => false,
                    "message" => "Not valid param name for this sensor"
                ], 422);
            }

            $paramValue = $params[$sensorParamName];

            if (!is_numeric($paramValue)) {
                return response()->json([
                    "status"  => false,
                    "message" => "Invalid parameter name for sensor"
                ], 422);
            }

            SensorMeasurements::create([
                "sensor_id" => $sensorId,
                "value"     => $paramValue
            ]);

            return response()->json([
                "status" => true
            ]);
        } catch (\Throwable $exception) {
            return response([
                "status" => false,
                "error"  => $exception->getMessage()
            ], 500);
        }
    }
}
