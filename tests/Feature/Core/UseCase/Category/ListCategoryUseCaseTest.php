<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryListInputDTO;
use Tests\TestCase;

class ListCategoryUseCaseTest extends TestCase
{
    public function testListExecute()
    {
        $categoryDB = ModelCategory::factory()->create();

        $repository = new CategoryRepositoryEloquent(new ModelCategory());
        $useCase = new ListCategoryUseCase($repository);

        $inputDTO = new CategoryListInputDTO(id: $categoryDB->id);
        $responseUseCase = $useCase->execute($inputDTO);

        self::assertEquals($categoryDB->id, $responseUseCase->id);
        self::assertEquals($categoryDB->name, $responseUseCase->name);
        self::assertEquals($categoryDB->description, $responseUseCase->description);
    }
}
