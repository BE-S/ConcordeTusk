<?php

namespace App\Jobs;

use App\Models\Api\Sensor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SensorJob implements ShouldQueue
{
    protected iterable $sensors;



    /**
     * Create a new job instance.
     */
    public function __construct(iterable $sensors)
    {
        $this->sensors   = $sensors;
    }

    /**
     * Execute the job.
     */
    public function handle(string $beginDate, string $endDate): array
    {
        $list = [];

        foreach ($this->sensors as $sensor) {
            $sensorId        = $sensor->id         ?? null;
            $sensorParamName = $sensor->param_name ?? null;

            $measurements = $sensor->getMeasurementsInterval($beginDate, $endDate);

            $list[$sensorId] = [
                "paramName" => $sensorParamName,
                "list"     => []
            ];

            foreach ($measurements as $measurement) {
                $createdAt = (string) ($measurement->created_at ?? "");

                $value = $measurement->value;

                $list[$sensorId]["list"][] = [
                    "date"  => $createdAt,
                    "value" => $value
                ];
            }
        }

        return $list;
    }


}
