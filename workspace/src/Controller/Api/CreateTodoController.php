<?php

namespace App\Controller\Api;

use App\Controller\AbstractApiController;
use App\RequestValidator\Todo\CreateTodoRequestValidator;
use App\Resource\error\GeneralErrorResource;
use App\Service\TodoServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateTodoController extends AbstractApiController
{
    public function __construct(public TodoServiceInterface $todoService)
    {
    }

    #[Route('/api/todos', methods: ['POST'])]
    public function createTodo(CreateTodoRequestValidator $requestValidator): JsonResponse
    {
        try {
            [
                'title' => $title,
                'description' => $description,
                'status' => $status,
            ] = $requestValidator->validateFields();

            $todoDto = $this->todoService->createTodo(
                title: $title,
                status: $status,
                description: $description,
            );

            return $this->response($todoDto, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return GeneralErrorResource::response($e);
        }
    }
}