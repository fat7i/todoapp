<?php

namespace App\Controller\Api;

use App\Controller\AbstractApiController;
use App\RequestValidator\Todo\GetTodoRequestValidator;
use App\Resource\error\GeneralErrorResource;
use App\Service\TodoServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetTodoController extends AbstractApiController
{
    public function __construct(public TodoServiceInterface $todoService)
    {
    }

    #[Route('/api/todos/{id}', methods: ['GET'])]
    public function getTodo(GetTodoRequestValidator $requestValidator): JsonResponse
    {
        try {
            [
                'id' => $todoId,
            ] = $requestValidator->validateFields();

            $todoDto = $this->todoService->getTodo($todoId);

            return $this->response($todoDto);
        } catch (\Exception $e) {
            return GeneralErrorResource::response($e);
        }
    }
}
