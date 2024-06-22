<?php

namespace App\Tests\Mocks\Service;

use App\Dto\TodoDto;
use App\Dto\TodosListDto;
use App\Exception\ResourceNotFoundException;
use App\Exception\ValidationErrorException;
use App\Service\TodoServiceInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Ramsey\Collection\Collection;

readonly class TodoServiceMock implements TodoServiceInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    public function getTodo(int $id): ?TodoDto
    {
        $mockParam = $this->requestStack->getCurrentRequest()->headers->get('mock-response');

        if ($mockParam === 'invalidParam') {
            throw new ValidationErrorException();
        }

        if ($mockParam === 'unknownError') {
            throw new \RuntimeException();
        }

        if ($mockParam === 'notFound') {
            throw new ResourceNotFoundException();
        }

        return new TodoDto(1, 'test-title', 'test-status', 'test-description');
    }

    public function createTodo(string $title, string $status, ?string $description = null): TodoDto
    {
        $mockParam = $this->requestStack->getCurrentRequest()->headers->get('mock-response');

        if ($mockParam === 'invalidParam') {
            throw new ValidationErrorException();
        }

        if ($mockParam === 'unknownError') {
            throw new \RuntimeException();
        }

        return new TodoDto(1, 'test-title', 'test-status', 'test-description');
    }

    public function updateTodo(int $id, string $title, string $status, ?string $description = null): TodoDto
    {
        $mockParam = $this->requestStack->getCurrentRequest()->headers->get('mock-response');

        if ($mockParam === 'invalidParam') {
            throw new ValidationErrorException();
        }

        if ($mockParam === 'unknownError') {
            throw new \RuntimeException();
        }

        if ($mockParam === 'notFound') {
            throw new ResourceNotFoundException();
        }

        return new TodoDto(1, 'test-title', 'test-status', 'test-description');
    }

    public function deleteTodo(int $id): void
    {
        $mockParam = $this->requestStack->getCurrentRequest()->headers->get('mock-response');

        if ($mockParam === 'invalidParam') {
            throw new ValidationErrorException();
        }

        if ($mockParam === 'unknownError') {
            throw new \RuntimeException();
        }

        if ($mockParam === 'notFound') {
            throw new ResourceNotFoundException();
        }
    }

    public function getTodosList(int $page = 1, int $limit = 10): TodosListDto
    {
        $mockParam = $this->requestStack->getCurrentRequest()->headers->get('mock-response');

        if ($mockParam === 'invalidParam') {
            throw new ValidationErrorException();
        }

        if ($mockParam === 'unknownError') {
            throw new \RuntimeException();
        }

        return new TodosListDto(
            1,
            1,
            1,
            1,
            new Collection(TodoDto::class, [])
        );
    }
}