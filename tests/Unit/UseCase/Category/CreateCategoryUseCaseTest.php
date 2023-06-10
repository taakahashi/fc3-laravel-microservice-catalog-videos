<?php

namespace Tests\Unit\UseCase\Category\CreateCategory;

use stdClass;
use Mockery;
use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\CreateCategory\CategoryCreateInputDTO;
use Core\UseCase\DTO\Category\CreateCategory\CategoryCreateOutputDTO;
use Core\UseCase\Category\CreateCategoryUseCase;

class CreateCategoryUseCaseTest extends TestCase
{

    public function testCreateNewCategory()
    {
        $categoryName = 'Name Category Test';

        $this->mockEntity = Mockery::mock(Category::class, [
            '',
            $categoryName
        ]);

        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d'));

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('insert')->andReturn($this->mockEntity);

        $this->mockInputDTO = Mockery::mock(CategoryCreateInputDTO::class, [
            $categoryName,
        ]);

        $useCase = new CreateCategoryUseCase($this->mockRepository);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(CategoryCreateOutputDTO::class, $responseUseCase);
        $this->assertEquals($categoryName, $responseUseCase->name);
        $this->assertEquals('', $responseUseCase->description);

        //Spies
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($this->mockEntity);

        $useCase = new CreateCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDTO);

        $this->spy->shouldHaveReceived('insert');
        //Spies

        Mockery::close();
    }
}
