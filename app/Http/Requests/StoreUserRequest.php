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
            'username' => ['required', 'unique:users', 'string', 'min:8', 'regex:/^\S*$/u'],
            'email' => ['required', 'unique:users', 'string', 'max:255', 'email', function ($attribute, $value, $fail) {
                $allowedDomains = ['gmail.com', 'yahoo.com', 'yahoo.co.id', 'outlook.com', 'polman.astra.ac.id', 'polytechnic.astra.ac.id']; // Sesuaikan dengan daftar domain yang diizinkan
            
                $domain = explode('@', $value)[1];
            
                if (!in_array($domain, $allowedDomains)) {
                    $fail($attribute.' is not a valid email domain.');
                }
            }],
            'npk' => ['required', 'string', 'unique:users', 'min:5'],
            'fullname' => ['required', 'string', 'max:255'],
            'divisi_id' => ['required'],
        ];
    }
}