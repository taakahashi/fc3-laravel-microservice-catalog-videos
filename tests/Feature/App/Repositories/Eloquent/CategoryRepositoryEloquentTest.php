<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use Tests\TestCase;
use App\Models\Category as ModelCategory;
use Core\Domain\Entity\Category as EntityCategory;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use Core\Domain\Repository\CategoryRepositoryInterface;

class CategoryRepositoryEloquentTest extends TestCase
{

    public function testInsert()
    {
        $repository = new CategoryRepositoryEloquent(new ModelCategory());

        $entityCategory = new EntityCategory(
            name: 'Teste 123'
        );

        $response = $repository->insert($entityCategory);

        self::assertInstanceOf(CategoryRepositoryInterface::class, $repository);
        self::assertInstanceOf(EntityCategory::class, $response);
        self::assertDatabaseHas('categories', [
            'name' => $entityCategory->name
        ]);
    }
}
