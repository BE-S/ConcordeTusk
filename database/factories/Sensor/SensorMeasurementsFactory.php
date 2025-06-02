<?php

namespace Database\Factories\Sensor;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sensor\SensorMeasurements>
 */
class SensorMeasurementsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sensorId = rand(1, 3);

        //
        // Минимальные и максимальные показатели датчиков
        //
        $sensorValue = match ($sensorId) {
            1 => rand(-273, 1260), // температура в цельсиях
            2 => rand(0, 1000),    // давление в барах
            3 => rand(0, 500000)   // обороты
        };

        return [
            "sensor_id" => $sensorId,
            "value" => $sensorValue,
        ];
    }
}
