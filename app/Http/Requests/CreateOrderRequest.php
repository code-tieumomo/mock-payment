<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'success_url' => 'required|url',
            'cancel_url' => 'required|url',
            'failure_url' => 'required|url',
            'extras' => 'nullable',

            'order_items' => 'required|array|min:1',
            'order_items.*.name' => 'required|string|max:255',
            'order_items.*.price' => 'required|numeric|min:0',
            'order_items.*.discount' => 'nullable|numeric|min:0',
            'order_items.*.tax' => 'nullable|numeric|min:0',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.thumbnail' => 'nullable|url',
            'order_items.*.extras' => 'nullable',
        ];
    }
}
