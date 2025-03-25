<?php

namespace Feature;

use Tests\TestCase;

class SensorTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_compliance_with_all_values(): void
    {
        $response = $this->call("GET", "api/?sensor=1", [], [], [], [], "T=999");

        $response->assertStatus(200)->assertJson([
            "status" => true
        ]);
    }

    public function test_attempt_add_value_without_not_valid_value()
    {
        $response = $this->call("GET", "api/?sensor=1", [], [], [], [], "T=<a href'https://google.com/'>Press button</a>");

        $response->assertStatus(422)->assertJson([
            "status" => false,
            "message" => "Invalid parameter name for sensor"
        ]);
    }

    public function test_attempt_add_value_without_value()
    {
        $response = $this->call("GET", "api/?sensor=1", [], [], [], [], "");

        $response->assertStatus(422)->assertJson([
            "status" => false,
            "message" => "Not valid param name for this sensor"
        ]);
    }
}
