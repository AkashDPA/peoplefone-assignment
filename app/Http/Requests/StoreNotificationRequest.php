<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNotificationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type'        => ['required', Rule::in(config('notifications.type'))],
            'short_text'  => ['required', 'string', 'max:255'],
            'expires_at'  => ['required', 'date', 'after:yesterday'],
            'destination' => ['required', 'in:all,user'],
            'user_id'     => ['nullable', 'integer', 'required_if:destination,user'],
        ];
    }
}
