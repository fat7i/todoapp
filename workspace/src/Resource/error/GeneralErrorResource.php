<?php

namespace App\Resource\error;

use App\Exception\ResourceNotFoundException;
use App\Exception\ValidationErrorException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class GeneralErrorResource
{
    public static function response(Exception $e): JsonResponse
    {
        if ($e instanceof ResourceNotFoundException) {
            return self::responseNotFoundError($e->getMessage());
        }

        if ($e instanceof ValidationErrorException) {
            return self::responseValidationError($e->getMessage());
        }

        if ($e instanceof BadRequestException) {
            return self::responseBadRequest($e->getMessage());
        }

        return new JsonResponse(
            [
                'errors' => 'Unexpected Error',
                'message' => $e->getMessage(),
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    private static function responseNotFoundError(?string $message): JsonResponse
    {
        return new JsonResponse(
            [
                'errors' => $message,
            ],
            Response::HTTP_NOT_FOUND,
        );
    }

    private static function responseValidationError(?string $message): JsonResponse
    {
        return new JsonResponse(
            [
                'errors' => json_decode($message, true, 512, JSON_THROW_ON_ERROR)
            ],
            Response::HTTP_BAD_REQUEST,
        );
    }

    private static function responseBadRequest(?string $message): JsonResponse
    {
        return new JsonResponse(
            [
                'errors' => $message,
            ],
            Response::HTTP_BAD_REQUEST,
        );
    }
}
