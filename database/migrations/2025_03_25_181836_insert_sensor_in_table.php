<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\Sensor;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Sensor::create([
            "param_name" => "T"
        ]);

        Sensor::create([
            "param_name" => "P"
        ]);

        Sensor::create([
            "param_name" => "v"
        ]);
    }
};
