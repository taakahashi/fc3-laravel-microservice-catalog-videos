<?php

namespace Unit\UseCase\Category;

use Core\UseCase\DTO\Category\PaginationInterface;
use stdClass;
use Mockery;
use PHPUnit\Framework\TestCase;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesInputDTO;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesOutputDTO;


class ListCategoriesUseCaseTest extends TestCase
{
    public function testListCategoriesEmpty()
    {
        $mockPagination = $this->mockPagination();
        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

        $this->mockInputDTO = Mockery::mock(ListCategoriesInputDTO::class, ['filter', 'order']);

        $useCase = new ListCategoriesUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        self::assertCount(0, $responseUseCase->items);
        self::assertInstanceOf(ListCategoriesOutputDTO::class, $responseUseCase);

        //Spies
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('paginate')->andReturn($mockPagination);

        $useCase = new ListCategoriesUseCase($this->spy);
        $useCase->execute($this->mockInputDTO);

        $this->spy->shouldHaveReceived('paginate');
        //Spies
    }

    public function testListCategories()
    {
        $register = new stdClass();
        $register->id = 'id';
        $register->name = 'name';
        $register->description = 'description';
        $register->is_active = true;
        $register->created_at = '';
        $register->updated_at = '';

        $mockPagination = $this->mockPagination([$register]);

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

        $this->mockInputDTO = Mockery::mock(ListCategoriesInputDTO::class, ['filter', 'order']);

        $useCase = new ListCategoriesUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        self::assertCount(1, $responseUseCase->items);
        self::assertInstanceOf(stdClass::class, $responseUseCase->items[0]);
        self::assertInstanceOf(ListCategoriesOutputDTO::class, $responseUseCase);

        //Spies
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('paginate')->andReturn($mockPagination);

        $useCase = new ListCategoriesUseCase($this->spy);
        $useCase->execute($this->mockInputDTO);

        $this->spy->shouldHaveReceived('paginate');
        //Spies
    }

    protected function mockPagination(array $items = [])
    {
        $this->mockPagination = Mockery::mock(stdClass::class, PaginationInterface::class);

        $this->mockPagination->shouldReceive('items')->andReturn($items);
        $this->mockPagination->shouldReceive('total')->andReturn(0);
        $this->mockPagination->shouldReceive('currentPage')->andReturn(0);
        $this->mockPagination->shouldReceive('firstPage')->andReturn(0);
        $this->mockPagination->shouldReceive('lastPage')->andReturn(0);
        $this->mockPagination->shouldReceive('perPage')->andReturn(0);
        $this->mockPagination->shouldReceive('to')->andReturn(0);
        $this->mockPagination->shouldReceive('from')->andReturn(0);

        return $this->mockPagination;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}