<?php


namespace App\Http\Services;


use Illuminate\Http\JsonResponse;

class ResponseService
{
    public static function successResponse($message, int $statusCode = 200,
                                           string $messageKey = 'message'): JsonResponse
    {
        return response()->json([
            'error' => false,
            $messageKey => $message
        ], $statusCode);
    }

    public static function errorResponse($message, int $statusCode = 500, string $messageKey = 'message'): JsonResponse
    {
        return response()->json([
            'error' => true,
            $messageKey => $message
        ], $statusCode);
    }
}
