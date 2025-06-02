<?php

namespace Database\Seeders\Sensor;

use App\Models\Sensor\Sensor;
use Illuminate\Database\Seeder;
use App\Models\User\User;

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

        $userMinAndMaxId = User::selectRaw("min(id), max(id)")->first();

        $id = rand($userMinAndMaxId->min, $userMinAndMaxId->max);

        foreach ($sensors as $sensor) {
            $sensor["user_id"] = $id;

            Sensor::create($sensor);
        }
    }
}
