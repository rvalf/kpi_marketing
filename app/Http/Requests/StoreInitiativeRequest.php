<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInitiativeRequest extends FormRequest
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
            'activity_id' => ['required'],
            'initiative' => ['required'],
            'weight' => ['required', 'numeric', 'min:1'],
            'target_type' => ['required'],
            'target' => ['required', 'numeric', 'min:1'],
            'user_id' => ['required'],
        ];
    }
}