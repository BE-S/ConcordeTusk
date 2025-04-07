<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SensorRequest extends FormRequest
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
            "sensor" => [
                "required",
                "integer"
            ],
            "measurements" => [
                "required",
                "array"
            ],
            "measurements.*" => [
                "required",
                "integer"
            ]
        ];
    }

    protected function prepareForValidation()
    {
        preg_match("/([A-Za-z]+)=([0-9]+)/", $this->getContent(), $matches);

        if (!count($matches)) {
            return;
        }

        $key   =        $matches[1] ?? "";
        $value = (int) ($matches[2] ?? 0);

        $this->merge([
            "measurements" => [
                $key => $value
            ]
        ]);
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
