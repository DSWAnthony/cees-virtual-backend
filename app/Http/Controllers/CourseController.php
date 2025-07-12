<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PaginationHelper;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Service\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage = $request->query('per_page', 5);

        $courses = $this->courseService->getAllCoursesPaginated($perPage);

        $paginator = PaginationHelper::format($courses, CourseResource::class);

        return response()->json($paginator);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateCourseRequest $request)
    {
        $data = $request->validated();
        $course = $this->courseService->create($data, $request->file('image'));

        return response()->json($course, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, UpdateCourseRequest $request)
    {
        $data = $request->validated();
        $course = $this->courseService->update($id, $data, $request->file('image'));

        return response()->json($course);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
