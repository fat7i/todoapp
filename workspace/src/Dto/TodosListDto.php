<?php

namespace App\Dto;

use Ramsey\Collection\Collection;

readonly class TodosListDto
{
    public function __construct(
        public int $total,
        public int $page,
        public int $limit,
        public int $totalPages,
        /** @var Collection<TodoDto> */
        public Collection $todos,
    ) {
    }
}