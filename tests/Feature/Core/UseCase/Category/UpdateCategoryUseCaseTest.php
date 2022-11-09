<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateInputDTO;
use Tests\TestCase;

class UpdateCategoryUseCaseTest extends TestCase
{
    public function testUpdateExecuteWithoutDescription()
    {
        $categoryDB = ModelCategory::factory()->create();

        $repository = new CategoryRepositoryEloquent(new ModelCategory());
        $useCase = new UpdateCategoryUseCase($repository);

        $inputDTO = new CategoryUpdateInputDTO(
            id: $categoryDB->id,
            name: 'Name Updated'
        );
        $responseUseCase = $useCase->execute($inputDTO);

        self::assertEquals('Name Updated', $responseUseCase->name);
        self::assertEquals($categoryDB->description, $responseUseCase->description);

        self::assertDatabaseHas('categories', [
            'name' => $responseUseCase->name
        ]);
    }

    public function testUpdateExecuteWithDescription()
    {
        $categoryDB = ModelCategory::factory()->create();

        $repository = new CategoryRepositoryEloquent(new ModelCategory());
        $useCase = new UpdateCategoryUseCase($repository);

        $inputDTO = new CategoryUpdateInputDTO(
            id: $categoryDB->id,
            name: 'Name Updated',
            description: 'Description Updated'
        );
        $responseUseCase = $useCase->execute($inputDTO);

        self::assertEquals('Name Updated', $responseUseCase->name);
        self::assertEquals('Description Updated', $responseUseCase->description);

        self::assertDatabaseHas('categories', [
            'name' => $responseUseCase->name
        ]);
    }
}
