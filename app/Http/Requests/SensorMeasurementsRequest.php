<?php

namespace App\Http\Requests;

use App\Rules\ValidDateRule;
use App\Rules\ValidSensorRule;
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
            "sensor" => [
                "required",
                new ValidSensorRule()
            ],
            "beginDate" => [
                new ValidDateRule()
            ],
            "endDate" => [
                new ValidDateRule()
            ]
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function () use ($validator) {
            $beginDate = $this->beginDate;
            $endDate   = $this->endDate;

            $beginDate = is_numeric($beginDate) ? $beginDate : strtotime($beginDate);
            $endDate   = is_numeric($endDate)   ? $endDate   : strtotime($endDate);

            if (!ctype_digit($beginDate) || !ctype_digit($endDate)) {
                $validator->errors()->add("date", "In beginDate or endData float passed expected timestamp or date timestamp");
                return;
            }

            if ($beginDate > $endDate) {
                $validator->errors()->add("endDate", "endDate can't be greater startDate");
            }
        });
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                "success" => false,
                "errors"  => $validator->errors()->toArray()
            ], 422)
        );
    }
}
