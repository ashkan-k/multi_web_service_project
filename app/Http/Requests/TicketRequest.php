<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TicketRequest extends FormRequest
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
            'title' => 'required|string',
            'text' => 'required',
            'user_id' => 'required|exists:users,id',
            'ticket_category_id' => 'required|exists:ticket_categories,id',
            'ticket_frequently_asked_id' => 'required|exists:ticket_frequently_asked_questions,id',
            'ticket_subject_id' => 'required|exists:ticket_subjects,id',
            'file' => 'file|mimes:pdf,jpg,png,word,excel',
//            'status' => 'in:waiting,pending,support_response,user_response,done,close',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 400));
    }
}
