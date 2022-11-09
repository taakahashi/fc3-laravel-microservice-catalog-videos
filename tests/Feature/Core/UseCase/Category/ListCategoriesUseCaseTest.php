<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesInputDTO;
use Tests\TestCase;

class ListCategoriesUseCaseTest extends TestCase
{
    public function testListExecuteEmpty()
    {
        $responseUseCase = $this->createUseCase();

        self::assertCount(0, $responseUseCase->items);
    }

    public function testListExecuteAll()
    {
        $categoriesDB = ModelCategory::factory()->count(20)->create();
        $responseUseCase = $this->createUseCase();

        self::assertCount(15, $responseUseCase->items);
        self::assertEquals(count($categoriesDB), $responseUseCase->total);
    }

    private function createUseCase(): \Core\UseCase\DTO\Category\ListCategories\ListCategoriesOutputDTO
    {
        $repository = new CategoryRepositoryEloquent(new ModelCategory());
        $useCase = new ListCategoriesUseCase($repository);

        $inputDTO = new ListCategoriesInputDTO();
        return $useCase->execute($inputDTO);
    }
}
