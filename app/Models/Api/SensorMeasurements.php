<?php

namespace App\Models\Api;

use App\Http\Helpers\Date;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorMeasurements extends Model
{
    /** @use HasFactory<\Database\Factories\Api\SensorMeasurementsFactory> */
    use HasFactory;

    protected $dates = [
        "deleted_at"
    ];

    protected $guarded = [
        "created_at"
    ];

    protected $fillable = [
        "sensor_id",
        "value"
    ];
}
