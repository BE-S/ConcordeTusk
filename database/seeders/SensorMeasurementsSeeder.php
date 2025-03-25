<?php

namespace Database\Seeders;

use App\Models\Api\SensorMeasurements;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
