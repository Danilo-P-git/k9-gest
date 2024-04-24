<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
        switch ($this->method()) {

            case 'GET':
                return [
                    'sort' => 'required|string',
                    'order' => 'required|string',
                    'page' => 'required|integer',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date',
                    'categories' => 'nullable',
                    'type' => 'nullable|exists:transactions,transaction_type'
                ];
            case 'POST':
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                return [
                    'name' => 'required|string',
                    'description' => 'required|string',
                    'amount' => 'required|numeric',
                ];

            default:
                return [];
        }
    }
}
