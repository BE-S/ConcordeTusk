<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Date;
use App\Http\Resources\SensorMeasurementsResource;
use App\Models\Sensor\SensorMeasurements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SensorMeasurementsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(Auth::check());
        try {
            $sensorsId = $request->get("sensor");
            $beginDate = $request->get("beginDate");
            $endDate   = $request->get("endDate");

            $beginDate = Date::timestampToDate($beginDate);
            $endDate   = Date::timestampToDate($endDate);

            $list = Cache::remember("$sensorsId.$beginDate.$endDate", 60 * 60, function () use ($sensorsId, $beginDate, $endDate) {
                $sensor = Sensor::find($sensorsId);
                $sensorParamName = $sensor->param_name ?? "";

                return [
                    "sensorId"        => $sensorsId,
                    "sensorParamName" => $sensorParamName,
                    "values"          => SensorMeasurementsResource::collection(
                        SensorMeasurements::getMeasurementsInterval($sensorsId, $beginDate, $endDate)
                    )
                ];
            });

            return response()->json([
                "measurement" => $list
            ]);
        } catch (\Throwable $exception) {
            Log::critical($exception->getMessage() . ". " . __FILE__);

            return response([
                "error"  => $exception->getMessage()
            ], 500);
        }
    }
}
