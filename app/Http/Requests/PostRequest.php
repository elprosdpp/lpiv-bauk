<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required'],
            'title' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'category' => ['required'],
            'description' => ['required'],
            'image' => ['file', 'mimes:jpg,png,gif', 'max:3072'],
            'tags' => ['required', 'string'],
            'status' => ['required', 'string'],
        ];
    }
}
