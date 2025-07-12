<?php

namespace App\Http\Requests\Module;

use Illuminate\Foundation\Http\FormRequest;

class CreateModuleRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'order_num' => 'nullable|integer|min:1',

            'materials' => 'nullable|array',
            'materials.*.title' => 'required|string|max:255',
            'materials.*.description' => 'nullable|string|max:1000',
            'materials.*.file' => 'nullable|file|mimes:pdf,doc,docx,ppt,txt|max:2048',
            'materials.*.type' => 'string',


            'materials.*.quiz' => 'nullable|array',
            'materials.*.quiz.title' => 'required|string|max:255',
            'materials.*.quiz.description' => 'nullable|string|max:1000',
            'materials.*.quiz.open_date' => 'required|date',
            'materials.*.quiz.due_date' => 'required|date|after_or_equal:materials.*.quiz.open_date',
            'materials.*.quiz.time_limit' => 'required|integer|min:1',
            'materials.*.quiz.allowed_attempts' => 'required|integer|min:1',
            'materials.*.quiz.max_score' => 'required|numeric|min:0',
            'materials.*.quiz.automatic_grading' => 'boolean',
            'materials.*.quiz.active' => 'boolean',

            'materials.*.quiz.questions' => 'required|array',
            'materials.*.quiz.questions.*.question' => 'required|string|max:1000',
            'materials.*.quiz.questions.*.type' => 'required|in:multiple_choice,open,true_false',
            'materials.*.quiz.questions.*.score' => 'required|numeric|min:0',
            'materials.*.quiz.questions.*.order_num' => 'nullable|integer|min:1',
            'materials.*.quiz.questions.*.active' => 'boolean',
            
            'materials.*.quiz.questions.*.options' => 'required_if:materials.*.quiz.questions.*.type,multiple_choice|array',
            'materials.*.quiz.questions.*.options.*.option' => 'required|string|max:255',
            'materials.*.quiz.questions.*.options.*.is_correct' => 'required_if:materials.*.quiz.questions.*.type,multiple_choice|boolean',
            
        ];
    }


    public function moduleData(): array
    {
        return $this->only([
            'title',
            'description',
            'course_id',
            'start_date',
            'end_date',
            'is_active',
            'order_num'
        ]);
    }

    public function materialsData(): array
    {
        return collect($this->input('materials', []))->map(function ($material) {
            return collect($material)->only([
                'title',
                'description',
                'material',
                'material_type',
                'quiz'
            ])->toArray();
        })->toArray();
    }
}
