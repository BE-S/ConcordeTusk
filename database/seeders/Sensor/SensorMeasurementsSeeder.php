<?php

namespace Database\Seeders\Sensor;

use App\Models\Sensor\SensorMeasurements;
use Illuminate\Database\Seeder;

class SensorMeasurementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SensorMeasurements::factory()->count(100)->create();
    }
}
