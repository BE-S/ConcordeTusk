<?php

namespace Database\Seeders;

use App\Models\Api\Sensor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sensors =
        [
            [
                "param_name" => "T",
                "created_at" => now(config("app.timezone")),
                "updated_at" => now(config("app.timezone")),
            ],
            [
                "param_name" => "P",
                "created_at" => now(config("app.timezone")),
                "updated_at" => now(config("app.timezone")),
            ],
            [
                "param_name" => "v",
                "created_at" => now(config("app.timezone")),
                "updated_at" => now(config("app.timezone")),
            ],
        ];

        foreach ($sensors as $sensor) {
            Sensor::create($sensor);
        }
    }
}
