<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'title'         =>  ['required', 'string', 'max:50', 'unique:tasks,title,'.$this->task],
            'description'   =>  ['nullable', 'max:255'],
            'start_date'    =>  ['required', 'date'],
            'end_date'      =>  ['required', 'date'],
            'status'        =>  ['required', 'in:Not Started,In Progress,Completed'],
            'finish_date'   =>  ['nullable'],
        ];
    }
}
