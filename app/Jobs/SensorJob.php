<?php

namespace App\Jobs;

use App\Models\Api\Sensor;
use App\Models\Api\SensorMeasurements;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class SensorJob implements ShouldQueue
{
    use Queueable;

    protected Sensor|null $sensor;
    protected string $paramValue;

    /**
     * Конструктор класса
     */
    public function __construct(Sensor|null $sensor, string $paramValue)
    {
        $this->sensor     = $sensor;
        $this->paramValue = $paramValue;
    }

    /**
     * Выполнить установку записи в БД
     */
    public function handle(): void
    {
        $this->sensor->measurements()->create([
            "sensor_id" => $this->sensor->id,
            "value"     => $this->paramValue
        ]);
    }
}
