<?php

namespace App\Models\Sensor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sensor extends Model
{
    /** @use HasFactory<\Database\Factories\Api\SensorFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [
        "created_at"
    ];

    protected $fillable = [
        "sensor_id", "param_name"
    ];

    public function measurements()
    {
        return $this->hasMany(SensorMeasurements::class);
    }
}
