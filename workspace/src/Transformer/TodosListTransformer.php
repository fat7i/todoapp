<?php

namespace App\Transformer;

use App\Dto\TodosListDto;

readonly class TodosListTransformer
{
    public function __construct(
        private TodoTransformer $todoTransformer,
    )
    {
    }

    public function transform(int $total, int $page, int $limit, int $totalPages, iterable $todos): TodosListDto
    {
        return new TodosListDto(
            total: $total,
            page: $page,
            limit: $limit,
            totalPages: $totalPages,
            todos: $this->todoTransformer->transformMany($todos),
        );
    }
}