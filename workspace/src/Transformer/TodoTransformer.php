<?php

namespace App\Transformer;

use App\Dto\TodoDto;
use App\Entity\Todo;
use Ramsey\Collection\Collection;

class TodoTransformer
{
    public function transform(Todo $todo): TodoDto
    {
        return new TodoDto(
            id: $todo->getId(),
            title: $todo->getTitle(),
            status: $todo->getStatus()->value,
            createdAt: $todo->getCreatedAt()->format('d/m/Y H:i'),
            description: $todo->getDescription(),
            updatedAt: $todo->getUpdatedAt()?->format('d/m/Y H:i'),
        );
    }

    public function transformMany(iterable $todos): Collection
    {
        $collection = new Collection(TodoDto::class);

        foreach ($todos as $todo) {
            $collection->add($this->transform($todo));
        }

        return $collection;
    }
}