<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TicketAnswerRequest extends FormRequest
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
            'text' => 'required',
            'file' => 'file|mimes:pdf,jpg,png,word,excel',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        if (request()->isJson()){
            throw new HttpResponseException(response()->json([
                'message' => 'Validation errors',
                'data' => $validator->errors()
            ], 400));
        }
        parent::failedValidation($validator);
    }
}
