<?php

namespace Tests\Feature;

use Database\Seeders\Sensor\SensorMeasurementsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SensorMeasurementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_obtaining_sensor_readings(): void
    {
        $this->seed(SensorMeasurementsSeeder::class);

        $sensor = Sensor::first();

        $measurement = $sensor->measurements->first();

        $getParams = [
            "sensor" => $sensor->id,
            "begin"  => $measurement->created_at->timestamp,
            "end"    => $measurement->updated_at->timestamp,
        ];

        $query = http_build_query($getParams);

        $response = $this->get("api/get/?" . $query);

        $response->assertStatus(200)->assertJson([
            "status" => true,
            "measurement" => [
                $sensor->id => [
                    "paramName" => $sensor->param_name,
                    "list"      => [
                        0 => [
                            "value" => $measurement->value,
                            "date"  => (string) $measurement->created_at
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function test_attempt_to_get_data_from_non_existent_sensor(): void
    {
        $getParams = [
            "sensor" => 0,
            "begin" => 1700000000,
            "end" => 1700000000
        ];

        $query = http_build_query($getParams);

        $response = $this->get("api/get/?" . $query);

        $response->assertStatus(422)->assertJson([
            "status"  => false,
            "message" => "Sensor not found"
        ]);
    }
}
