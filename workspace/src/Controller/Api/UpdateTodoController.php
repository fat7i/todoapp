<?php

namespace App\Controller\Api;

use App\Controller\AbstractApiController;
use App\RequestValidator\Todo\UpdateTodoRequestValidator;
use App\Resource\error\GeneralErrorResource;
use App\Service\TodoServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UpdateTodoController extends AbstractApiController
{
    public function __construct(public TodoServiceInterface $todoService)
    {
    }

    #[Route('/api/todos/{id}', methods: ['PUT'])]
    public function createTodo(UpdateTodoRequestValidator $requestValidator): JsonResponse
    {
        try {
            [
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'status' => $status,
            ] = $requestValidator->validateFields();

            $todoDto = $this->todoService->updateTodo(
                id: $id,
                title: $title,
                status: $status,
                description: $description,
            );

            return $this->response($todoDto);
        } catch (\Exception $e) {
            return GeneralErrorResource::response($e);
        }
    }
}