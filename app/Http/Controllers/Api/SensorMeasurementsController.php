<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Date;
use App\Http\Requests\SensorMeasurementsRequest;
use App\Jobs\SensorJob;
use App\Models\Api\Sensor;
use App\Models\Api\SensorMeasurements;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SensorMeasurementsController extends Controller
{
    public function index(SensorMeasurementsRequest $request)
    {
        try {
            $sensorsId = $request->get("sensor");
            $beginDate = $request->get("beginDate");
            $endDate   = $request->get("endDate");

            $beginDate = Date::timestampToDate($beginDate);
            $endDate   = Date::timestampToDate($endDate);

            $list = Cache::remember("$sensorsId.$beginDate.$endDate", 60 * 60, function () use ($sensorsId, $beginDate, $endDate) {
                return SensorMeasurements::getMeasurementsInterval($sensorsId, $beginDate, $endDate);
            });

            return response()->json([
                "measurement" => $list
            ]);
        } catch (\Throwable $exception) {
            return response([
                "error"  => $exception->getMessage()
            ], 500);
        }
    }
}
