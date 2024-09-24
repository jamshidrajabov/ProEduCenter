<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomeworkRequest extends FormRequest
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
            'lesson_id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,png,pdf,docx,xlsx,xls,doc,zip,rar,ppt,pptx',
            'type' => 'required|string',
            'score_max' => 'required|numeric'
        ];
    }
}
