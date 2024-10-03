<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'attachment' => 'nullable|file',
            'iban' => 'required|integer|min:5', // فرض بگیریم که IBAN باید حداقل 5 کاراکتر باشه
        ];
    }
}
