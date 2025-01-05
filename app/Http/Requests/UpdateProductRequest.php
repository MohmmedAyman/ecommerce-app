<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'pro_name'=> 'string|max:255',
            'pro_description' => 'string', 
            'pro_price' => 'numeric',
            'pro_maincategory' => 'integer|exists:maincategories,id',
            'pro_category' => 'integer|exists:categories,id',
        ];
    }
}
