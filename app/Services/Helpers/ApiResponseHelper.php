<?php

namespace App\Services\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponseHelper
{
    public static function success(
        int $status_code = 200,
        string $message = '',
        array|object $data = [],
    ): JsonResponse {
        if ($message) {
            return response()->json([
                'status_code' => $status_code,
                'status' => 'success',
                'message' => $message,
                'data' => $data,
            ], $status_code);
        }

        return response()->json([
            'status_code' => $status_code,
            'status' => 'success',
            'data' => $data,
        ], $status_code);
    }

    public static function failed(
        string $errorMessage,
        int $status_code = 400,
        array $data = []
    ): JsonResponse {
        return response()->json([
            'status_code' => $status_code,
            'status' => 'failed',
            'data' => $data,
            'errorMessage' => $errorMessage,
        ], $status_code);
    }
}
