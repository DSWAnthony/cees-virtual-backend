<?php
namespace App\Service;
use App\Models\Module;
use App\Models\Quiz;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class ModuleService
{
    public function create(array $data, array $files): Module
    {
        return DB::transaction(function () use ($data, $files) {
            // Crear módulo
            $module = Module::create(attributes: [
                'course_id' => $data['course_id'],
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'order_num' => $data['order_num'] ?? 0,
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
                'is_active' => $data['is_active'] ?? true,
            ]);

            // Procesar materiales
            foreach ($data['materials'] as $index => $material) {
                $this->createMaterial($module, $material, $files[$index] ?? null);
            }

            return $module;
        });
    }

    private function createMaterial(Module $module, array $data, ?UploadedFile $file): void
    {
        $materialData = [
            'title' => $data['title'],
            'type' => $data['type'],
        ];

        switch ($data['type']) {
            case 'pdf':
            case 'assignment':
                $materialData['file_path'] = $this->storeFile($file);
                $materialData['content'] = $data['description'] ?? null;
                $module->materials()->create($materialData);
                break;

            case 'quiz':
                $quiz = Quiz::create([
                    'title' => $data['quiz']['title'],
                    'description' => $data['quiz']['description'] ?? null,
                    'time_limit' => $data['quiz']['time_limit'] ?? null,
                    'attempts' => $data['quiz']['attempts'] ?? 1,
                    'active' => $data['quiz']['active'] ?? true,
                    'course_id' => $module->course_id,
                ]);

                // Crear preguntas y opciones
                foreach ($data['quiz']['questions'] as $question) {
                    $q = $quiz->questions()->create([
                        'question' => $question['question'],
                        'type' => $question['type'],
                        'score' => $question['score'] ?? 1,
                        'order_num' => $question['order_num'] ?? 0,
                        'active' => $question['active'] ?? true,
                    ]);

                    foreach ($question['options'] as $option) {
                        $q->options()->create($option);
                    }
                }

                // Vincular quiz al material
                $materialData['quiz_id'] = $quiz->id;
                $module->materials()->create($materialData);
                break;
        }
    }

    private function storeFile(?UploadedFile $file): ?string
    {
        return $file ? $file->store('materials', 'public') : null;
    }
}