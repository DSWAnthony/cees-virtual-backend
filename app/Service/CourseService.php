<?php
namespace App\Service;

use App\Exceptions\Global\EntityAlreadyExistsException;
use App\Exceptions\Global\EntityNotFoundException;
use App\Http\Utils\DeleteImage;
use App\Models\Course;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class CourseService
{
    use DeleteImage;

    public function getAllCoursesPaginated(int $perPage) : LengthAwarePaginator {
        
        $query = Course::query()
            ->with(['teacher'])
            ->orderBy('created_at', 'desc');

        return $query->paginate($perPage);
    }


    public function create(array $data, ?UploadedFile $image): Course
    {
        // Verificar duplicado
        $exists = Course::where('title', $data['title'])
                        ->where('teacher_id', operator: $data['teacher_id'])
                        ->exists();

        if ($exists) {
            throw new EntityAlreadyExistsException(
                "El curso con título '{$data['title']}' ya existe para este docente.",
                409
            );
        }

        // Subir imagen (si aplica)
        if ($image) {
            $data['image_url'] = Storage::disk('public')->url($image->store('course', 'public'));
        }

        // Crear curso en transacción
        return DB::transaction(function () use ($data) {
            return Course::create($data);
        });
    }

    public function update(int $id, array $data, ?UploadedFile $image): Course
    {
        $course = Course::find($id);
        if (! $course) {
            throw new EntityNotFoundException("Curso con ID {$id} no encontrado.", 409);
        }

        if ($image) {
            if ($course->image_url) {
                $this->deleteImageForUrl($course->image_url);
            }
            $course->image_url = Storage::disk('public')->url($image->store('course', 'public'));
        }

        return DB::transaction(function () use ($course, $data) {
            $course->update($data);
            return $course;
        });
    }
}
