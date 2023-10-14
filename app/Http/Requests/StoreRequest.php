<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreRequest extends FormRequest
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
            "username" => 'ascii|max:255|required',
            "email" => 'email|max:255|required',
            "homepage_url" => 'max:255',
            "text" => "required",
            "parent_id" => "integer|numeric",
            "file" => ['mimes:jpg,jpeg,png,gif,txt', 'max:2000'],
        ];
    }
}
