<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class AlreadyVerifiedException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'errors' => [],
        ], 400);
    }
}
