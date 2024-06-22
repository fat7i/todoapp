<?php

namespace App\Controller\Api;

use App\Controller\AbstractApiController;
use App\RequestValidator\Todo\GetTodosListRequestValidator;
use App\Resource\error\GeneralErrorResource;
use App\Service\TodoServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetTodosListController extends AbstractApiController
{
    public function __construct(public TodoServiceInterface $todoService)
    {
    }

    #[Route('/api/todos', methods: ['GET'])]
    public function getTodo(GetTodosListRequestValidator $requestValidator): JsonResponse
    {
        try {
            [
                'page' => $page,
                'limit' => $limit,
            ] = $requestValidator->validateFields();

            $todosListDto = $this->todoService->getTodosList($page, $limit);

            return $this->response($todosListDto);
        } catch (\Exception $e) {
            return GeneralErrorResource::response($e);
        }
    }
}
