<?php

namespace Unit\UseCase\Category;

use stdClass;
use Mockery;
use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateInputDTO;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateOutputDTO;
use Core\UseCase\Category\UpdateCategoryUseCase;

class UpdateCategoryUseCaseTest extends TestCase
{

    public function testRenameCategory() {
        $uuid = Uuid::uuid4()->toString();
        $categoryName = 'Name';
        $categoryDesc = 'Desc';

        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid, $categoryName, $categoryDesc
        ]);

        $this->mockEntity->shouldReceive('update');
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d'));

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepository->shouldReceive('update')->andReturn($this->mockEntity);

        $this->mockInputDTO = Mockery::mock(CategoryUpdateInputDTO::class, [
            $uuid,
            'New Name'
        ]);

        $useCase = new UpdateCategoryUseCase($this->mockRepository);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        self::assertInstanceOf(CategoryUpdateOutputDTO::class, $responseUseCase);

        //Spies
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->spy->shouldReceive('update')->andReturn($this->mockEntity);

        $useCase = new UpdateCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDTO);

        $this->spy->shouldHaveReceived('findById');
        $this->spy->shouldHaveReceived('update');
        //Spies

        Mockery::close();
    }

}