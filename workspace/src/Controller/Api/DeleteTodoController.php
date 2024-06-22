<?php

namespace App\Controller\Api;

use App\Controller\AbstractApiController;
use App\RequestValidator\Todo\GetTodoRequestValidator;
use App\Resource\error\GeneralErrorResource;
use App\Service\TodoServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DeleteTodoController extends AbstractApiController
{
    public function __construct(public TodoServiceInterface $todoService)
    {
    }

    #[Route('/api/todos/{id}', methods: ['DELETE'])]
    public function getTodo(GetTodoRequestValidator $requestValidator): JsonResponse
    {
        try {
            [
                'id' => $todoId,
            ] = $requestValidator->validateFields();

            $this->todoService->deleteTodo($todoId);

            return $this->response(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return GeneralErrorResource::response($e);
        }
    }
}
