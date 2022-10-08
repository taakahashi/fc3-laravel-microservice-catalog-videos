<?php

namespace Unit\UseCase\Category;

use Ramsey\Uuid\Uuid;
use stdClass;
use Mockery;
use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\CategoryListInputDTO;
use Core\UseCase\DTO\Category\CategoryListOutputDTO;
use Core\UseCase\Category\ListCategoryUseCase;


class ListCategoryUseCaseTest extends TestCase
{

    public function testFindCategoryById()
    {
        $uuid = Uuid::uuid4()->toString();
        $categoryName = 'Name Category Test';

        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $categoryName
        ]);

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository
            ->shouldReceive('findById')
            ->with($uuid)
            ->andReturn($this->mockEntity);

        $this->mockInputDTO = Mockery::mock(CategoryListInputDTO::class, [
            $uuid,
        ]);

        $useCase = new ListCategoryUseCase($this->mockRepository);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(CategoryListOutputDTO::class, $responseUseCase);
        $this->assertEquals($categoryName, $responseUseCase->name);
        $this->assertEquals($uuid, $responseUseCase->id);

        //Spies
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);

        $useCase = new ListCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDTO);

        $this->spy->shouldHaveReceived('findById');
        //Spies

        Mockery::close();
    }
    
}