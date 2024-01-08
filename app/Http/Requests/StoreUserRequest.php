<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', 'unique:users', 'string', 'max:255', 'regex:/^\S*$/u'],
            'password' => ['required', 'string', 'min:8'], // Minimal 8 karakter
            'email' => ['required', 'unique:users', 'string', 'max:255', 'email'], // Validasi format email
            'fullname' => ['required', 'string', 'max:255'],
            'divisi_id' => ['required'],
        ];
    }
}
