<?php

namespace App\Models\Api;

use App\Http\Helpers\Date;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sensor extends Model
{
    /** @use HasFactory<\Database\Factories\Api\SensorFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [
        "param_name", "created_at"
    ];

    protected $fillable = [
        "sensor_id"
    ];

    public function measurements()
    {
        return $this->hasMany(SensorMeasurements::class);
    }
}
