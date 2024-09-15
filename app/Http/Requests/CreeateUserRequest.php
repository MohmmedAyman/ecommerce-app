<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

class CreeateUserRequest extends FormRequest
{

    // protected $stopOnFirstFailure = true;

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
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
        ];
    }

    protected function failedValidation(ValidationValidator $validator)
    {
        $bagErrors = $validator->getMessageBag()->getMessages();
        $error = [];
        foreach($bagErrors  as $key => $er){
            $error[$key] = $er[0];
        }

        $response = response()->json([
            'status' => false,
            'errors' => $error
        ],422);
        throw new HttpResponseException($response);
    }

    public function messages():array
    {
        return [
            'name.required' => 'name is require :)',
        ];
    }


}
