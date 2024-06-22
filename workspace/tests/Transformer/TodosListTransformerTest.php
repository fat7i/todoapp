<?php

namespace App\Tests\Transformer;

use App\Dto\TodoDto;
use App\Dto\TodosListDto;
use App\Transformer\TodoTransformer;
use App\Transformer\TodosListTransformer;
use PHPUnit\Framework\TestCase;
use Ramsey\Collection\Collection;
use Mockery;

class TodosListTransformerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testTransform(): void
    {
        $todoTransformer = Mockery::mock(TodoTransformer::class);
        $todoTransformer->shouldReceive('transformMany')
            ->once()
            ->andReturn(new Collection(TodoDto::class));

        $total = 8;
        $page = 2;
        $limit = 3;
        $totalPages = ceil($total / $limit);

        $todosListTransformer = new TodosListTransformer($todoTransformer);
        $todosListDto = $todosListTransformer->transform($total, $page, $limit, $totalPages, []);

        $this->assertInstanceOf(TodosListDto::class, $todosListDto);
        $this->assertEquals($total, $todosListDto->total);
        $this->assertEquals($page, $todosListDto->page);
        $this->assertEquals($limit, $todosListDto->limit);
        $this->assertEquals($totalPages, $todosListDto->totalPages);
        $this->assertInstanceOf(Collection::class, $todosListDto->todos);
        $this->assertCount(0, $todosListDto->todos);
    }
}

