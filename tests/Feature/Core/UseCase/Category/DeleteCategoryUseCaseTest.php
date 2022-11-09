<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryListInputDTO;
use Tests\TestCase;

class DeleteCategoryUseCaseTest extends TestCase
{
    public function testDeleteExecute()
    {
        $categoryDB = ModelCategory::factory()->create();

        $repository = new CategoryRepositoryEloquent(new ModelCategory());
        $useCase = new DeleteCategoryUseCase($repository);

        $inputDTO = new CategoryListInputDTO(id: $categoryDB->id);
        $useCase->execute($inputDTO);

        self::assertSoftDeleted($categoryDB);
    }
}
