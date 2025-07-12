<?php

namespace App\Exceptions\Global;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EntityNotFoundException extends Exception
{
    public function render(Request $request): Response|JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage()
        ], $this->getCode());
    }
      
}
