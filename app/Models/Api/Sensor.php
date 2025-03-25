<?php

namespace App\Models\Api;

use App\Http\Helpers\Date;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;

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

    protected $attributes = [
        "param_name" => ""
    ];

    public function measurements(): HasMany
    {
        return $this->hasMany(SensorMeasurements::class, "sensor_id");
    }

    public function getMeasurementsInterval(string|int $begin = "", string|int $end = ""): Collection
    {
        $begin = Date::timestampToDate($begin);
        $end = Date::timestampToDate($end);

        $measurements = $this->measurements();

        if (strlen($begin)) {
            $measurements->where("created_at", ">=", $begin);
        }

        if (strlen($end)) {
            $measurements->where("created_at", "<=", $end);
        }

        return $measurements->get();
    }

    public function getSensor(string|array $sensors)
    {
        return match (true) {
            is_array($sensors)        => $this->whereIn("id", $sensors)->get(),
            is_numeric($sensors)      => $this->where("id", $sensors)->get(),
            $_GET["sensor"] === "all" => $this->all(),
            default => null
        };
    }
}
