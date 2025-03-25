<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SensorMeasurementsRequest;
use App\Jobs\SensorJob;
use App\Models\Api\Sensor;
use App\Models\Api\SensorMeasurements;
use Carbon\Carbon;

class SensorMeasurementsController extends Controller
{
    public function index(SensorMeasurementsRequest $request)
    {
        try {
            $sensorsId   = $request->get("sensor");
            $beginDate = $request->get("begin", "");
            $endDate   = $request->get("end", "");

            $sensorModel = new Sensor();

            $sensors = $sensorModel->getSensor($sensorsId);

            if (!$sensors || !count($sensors)) {
                return response()->json([
                    "status"  => false,
                    "message" => "Sensor not found"
                ], 422);
            }

            $sensorJob = new SensorJob($sensors);
            $list = $sensorJob->handle($beginDate, $endDate);

            return response()->json([
                "status"      => true,
                "measurement" => $list
            ]);
        } catch (\Throwable $exception) {
            return response([
                "status" => false,
                "error"  => $exception->getMessage()
            ], 500);
        }
    }
}
