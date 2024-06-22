<?php

namespace App\Service;

use App\Dto\TodoDto;
use App\Dto\TodosListDto;
use App\Entity\Todo;
use App\Enum\StatusEnum;
use App\Exception\ResourceNotFoundException;
use App\Repository\TodoRepository;
use App\Transformer\TodoTransformer;
use App\Transformer\TodosListTransformer;

readonly class TodoService implements TodoServiceInterface
{
    public function __construct(
        private TodoTransformer $todoTransformer,
        private TodosListTransformer $todosListTransformer,
        private TodoRepository $todoRepository,
    )
    {
    }

    public function getTodo(int $id): ?TodoDto
    {
        /** @var ?Todo $todo */
        $todo = $this->todoRepository->findById($id);

        if ($todo === null) {
            throw new ResourceNotFoundException('Todo not found');
        }

        return $this->todoTransformer->transform($todo);
    }

    public function createTodo(string $title, string $status, ?string $description = null): TodoDto
    {
        $todo = new Todo();
        $todo->setTitle($title);
        $todo->setDescription($description);
        $todo->setStatus(StatusEnum::from($status));
        $this->todoRepository->save($todo);

        return $this->todoTransformer->transform($todo);
    }

    public function updateTodo(int $id, string $title, string $status, ?string $description = null): TodoDto
    {
        /** @var ?Todo $todo */
        $todo = $this->todoRepository->findById($id);

        if ($todo === null) {
            throw new ResourceNotFoundException('Todo not found');
        }

        $todo->setTitle($title);
        $todo->setDescription($description);
        $todo->setStatus(StatusEnum::from($status));
        $this->todoRepository->save($todo);

        return $this->todoTransformer->transform($todo);
    }

    public function deleteTodo(int $id): void
    {
        /** @var ?Todo $todo */
        $todo = $this->todoRepository->findById($id);

        if ($todo === null) {
            throw new ResourceNotFoundException('Todo not found');
        }

        $todo->softDelete();
        $this->todoRepository->save($todo);
    }

    public function getTodosList(int $page = 1, int $limit = 10): TodosListDto
    {
        $todos = $this->todoRepository->findAllWithPagination($page, $limit);

        return $this->todosListTransformer->transform(
            total: count($todos),
            page: $page,
            limit: $limit,
            totalPages: ceil(count($todos) / $limit),
            todos: $todos,
        );
    }
}