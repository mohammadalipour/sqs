<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RegisterDeviceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'app_id' => 'required',
            'app_version' => 'required|string',
            'identifier' => 'required|string',
            'token' => 'required|unique:devices',
            'type' => 'required|in:ios,android',
            'device_model' => 'sometimes|string',
            'language' => 'required|string|max:2',
            'country' => 'sometimes|string',
            'timezone' => 'sometimes|string',
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(
                ['errors' => $errors],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
