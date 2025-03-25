<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SensorMeasurementsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "sensor.*" => "required|numeric"
        ];
    }

    public function messages(): array
    {
        return [
            "sensor.required"  => "Value for param 'sensor' is missing",
            "sensor.integer"   => "Param 'sensor' must be type integer",
        ];
    }

    protected function withValidator($validator)
    {
        $validator->sometimes("sensor", "numeric", function ($input) {
            return is_numeric($input->sensor) && !is_string($input->sensor);
        });

        $validator->sometimes("sensor", "array", function ($input) {
            return is_array($input->sensor);
        });

        $validator->sometimes("begin", "nullable", function ($input) {
            return !isset($input->begin);
        });

        $validator->sometimes("begin", "integer", function ($input) {
            return is_int($input->begin);
        });

        $validator->sometimes("begin", "date", function ($input) {
            return strtotime($input->begin) !== false;
        });
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                "success" => false,
                "errors"  => $validator->errors()->toJson()
            ], 422)
        );
    }
}
