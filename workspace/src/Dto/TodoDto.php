<?php

namespace App\Dto;

readonly class TodoDto
{
    public function __construct(
        public int $id,
        public string $title,
        public string $status,
        public string $createdAt,
        public ?string $description = null,
        public ?string $updatedAt = null,
    ) {
    }
}