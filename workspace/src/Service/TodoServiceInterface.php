<?php

namespace App\Service;

use App\Dto\TodoDto;
use App\Dto\TodosListDto;

interface TodoServiceInterface
{
    public function getTodo(int $id): ?TodoDto;

    public function createTodo(string $title, string $status, ?string $description = null): TodoDto;

    public function updateTodo(int $id, string $title, string $status, ?string $description = null): TodoDto;

    public function deleteTodo(int $id): void;

    public function getTodosList(int $page = 1, int $limit = 10): TodosListDto;
}
