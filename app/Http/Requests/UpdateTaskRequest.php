<?php

namespace App\Http\Requests;

use App\Models\Task;
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
            'title' => 'required',
            'description' => 'required',
            'deadline' => 'required|date',
            'priority' => 'required|in:' . implode(',', Task::PRIORITY),
            'status' => 'required|in:' . implode(',', Task::STATUS),
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}
