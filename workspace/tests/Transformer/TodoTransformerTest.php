<?php

namespace App\Tests\Transformer;

use App\Dto\TodoDto;
use App\Entity\Todo;
use App\Enum\StatusEnum;
use App\Transformer\TodoTransformer;
use PHPUnit\Framework\TestCase;
use Ramsey\Collection\Collection;
use DateTimeImmutable;

class TodoTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $todo = new Todo();
        $todo->setId(1);
        $todo->setTitle('Test Todo');
        $todo->setStatus(StatusEnum::STATUS_PENDING);
        $todo->setCreatedAt(new DateTimeImmutable('2023-06-21 12:00:00'));
        $todo->setDescription('Test Description');
        $todo->setUpdatedAt(new DateTimeImmutable('2023-06-21 12:30:00'));

        $transformer = new TodoTransformer();
        $todoDto = $transformer->transform($todo);

        $this->assertInstanceOf(TodoDto::class, $todoDto);
        $this->assertEquals(1, $todoDto->id);
        $this->assertEquals('Test Todo', $todoDto->title);
        $this->assertEquals('pending', $todoDto->status);
        $this->assertEquals('21/06/2023 12:00', $todoDto->createdAt);
        $this->assertEquals('Test Description', $todoDto->description);
        $this->assertEquals('21/06/2023 12:30', $todoDto->updatedAt);
    }

    public function testTransformMany(): void
    {
        $todo1 = new Todo();
        $todo1->setId(1);
        $todo1->setTitle('Test Todo 1');
        $todo1->setStatus(StatusEnum::STATUS_PENDING);
        $todo1->setCreatedAt(new DateTimeImmutable('2023-06-21 12:00:00'));
        $todo1->setDescription('Test Description 1');
        $todo1->setUpdatedAt(new DateTimeImmutable('2023-06-21 12:30:00'));

        $todo2 = new Todo();
        $todo2->setId(2);
        $todo2->setTitle('Test Todo 2');
        $todo2->setStatus(StatusEnum::STATUS_COMPLETED);
        $todo2->setCreatedAt(new DateTimeImmutable('2023-06-22 12:00:00'));
        $todo2->setDescription('Test Description 2');
        $todo2->setUpdatedAt(new DateTimeImmutable('2023-06-22 12:30:00'));

        $todos = [$todo1, $todo2];

        $transformer = new TodoTransformer();
        $todoDtos = $transformer->transformMany($todos);

        $this->assertInstanceOf(Collection::class, $todoDtos);
        $this->assertCount(2, $todoDtos);

        $todoDto1 = $todoDtos[0];
        $this->assertInstanceOf(TodoDto::class, $todoDto1);
        $this->assertEquals(1, $todoDto1->id);
        $this->assertEquals('Test Todo 1', $todoDto1->title);
        $this->assertEquals('pending', $todoDto1->status);
        $this->assertEquals('21/06/2023 12:00', $todoDto1->createdAt);
        $this->assertEquals('Test Description 1', $todoDto1->description);
        $this->assertEquals('21/06/2023 12:30', $todoDto1->updatedAt);

        $todoDto2 = $todoDtos[1];
        $this->assertInstanceOf(TodoDto::class, $todoDto2);
        $this->assertEquals(2, $todoDto2->id);
        $this->assertEquals('Test Todo 2', $todoDto2->title);
        $this->assertEquals('completed', $todoDto2->status);
        $this->assertEquals('22/06/2023 12:00', $todoDto2->createdAt);
        $this->assertEquals('Test Description 2', $todoDto2->description);
        $this->assertEquals('22/06/2023 12:30', $todoDto2->updatedAt);
    }
}
