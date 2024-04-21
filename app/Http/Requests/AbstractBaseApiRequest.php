<?php


namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class AbstractBaseApiRequest extends FormRequest
{
    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $failed = [];
        foreach ($errors->keys() as $key) {
            $failed[$key] = $errors->get($key);
        }
        throw new HttpResponseException(response()->json($failed, 422));
    }
}
