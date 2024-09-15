<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginRequest extends FormRequest
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
                'email' => 'required',
                'password' => 'required'
        ];
    }

    public function failedValidation(Validator $validator){
        $errors = $validator->errors()->getMessages();
        $result=[];
        foreach($errors as $key => $val){
            $result[$key] = $val[0];
        }
        
        $response = Response()->json([
            'status' => false,
            'errors' => $result
        ],400);


        throw new HttpResponseException($response);
    }
}
