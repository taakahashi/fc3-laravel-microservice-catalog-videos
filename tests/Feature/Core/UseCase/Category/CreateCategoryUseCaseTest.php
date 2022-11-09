<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\CreateCategory\CategoryCreateInputDTO;
use Tests\TestCase;

class CreateCategoryUseCaseTest extends TestCase
{
    public function testCreateExecute()
    {
        $repository = new CategoryRepositoryEloquent(new ModelCategory());
        $useCase = new CreateCategoryUseCase($repository);

        $inputDTO = new CategoryCreateInputDTO(name: 'Test');
        $responseUseCase = $useCase->execute($inputDTO);

        self::assertEquals('Test', $responseUseCase->name);
        self::assertNotEmpty($responseUseCase->id);

        self::assertDatabaseHas('categories', [
            'id' => $responseUseCase->id
        ]);
    }
}
