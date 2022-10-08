<?php

namespace Unit\UseCase\Category;

use stdClass;
use Mockery;
use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\CategoryListInputDTO;
use Core\UseCase\DTO\Category\DeleteCategory\CategoryDeleteOutputDTO;
use Core\UseCase\Category\DeleteCategoryUseCase;

class DeleteCategoryUseCaseTest extends TestCase
{

    public function testDelete()
    {
        $uuid = Uuid::uuid4()->toString();

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('delete')->andReturn(true);

        $this->mockInputDTO = Mockery::mock(CategoryListInputDTO::class, [$uuid]);

        $useCase = new DeleteCategoryUseCase($this->mockRepository);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(CategoryDeleteOutputDTO::class, $responseUseCase);
        $this->assertTrue($responseUseCase->success);

        //Spies
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('delete')->andReturn(true);

        $useCase = new DeleteCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDTO);

        $this->spy->shouldHaveReceived('delete');
        //Spies
    }

    public function testDeleteFalse()
    {
        $uuid = Uuid::uuid4()->toString();

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('delete')->andReturn(false);

        $this->mockInputDTO = Mockery::mock(CategoryListInputDTO::class, [$uuid]);

        $useCase = new DeleteCategoryUseCase($this->mockRepository);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(CategoryDeleteOutputDTO::class, $responseUseCase);
        $this->assertFalse($responseUseCase->success);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

}