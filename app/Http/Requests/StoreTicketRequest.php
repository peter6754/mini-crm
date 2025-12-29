<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            'theme' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'status' => ['nullable', 'in:new,in_progress,done'],
            'answered_at' => ['nullable', 'date'],
            'customer_id' => ['required', 'exists:customers,id'],
        ];
    }
}
