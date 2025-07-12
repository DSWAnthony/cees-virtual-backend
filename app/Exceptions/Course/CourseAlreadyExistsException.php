<?php

namespace App\Exceptions\Course;
    
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseAlreadyExistsException extends Exception
{

    public function render(Request $request): Response|JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
