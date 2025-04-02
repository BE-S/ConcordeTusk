<?php

namespace App\Models\Api;

use App\Http\Helpers\Date;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SensorMeasurements extends Model
{
    /** @use HasFactory<\Database\Factories\Api\SensorMeasurementsFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [
        "created_at"
    ];

    protected $fillable = [
        "sensor_id",
        "value"
    ];

    public static function getMeasurementsInterval(int $sensorId, string $beginDate = "", string $endDate = ""): Collection
    {
        return self::where("sensor_id", $sensorId)->whereBetween("created_at", [$beginDate, $endDate])->get();
    }
}
