<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use Tests\TestCase;
use App\Models\Category as ModelCategory;
use Core\Domain\Entity\Category as EntityCategory;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Exception\NotFoundException;

class CategoryRepositoryEloquentTest extends TestCase
{

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CategoryRepositoryEloquent(new ModelCategory());
    }

    public function testInsert()
    {

        $entityCategory = new EntityCategory(
            name: 'Teste 123'
        );

        $response = $this->repository->insert($entityCategory);

        self::assertInstanceOf(CategoryRepositoryInterface::class, $this->repository);
        self::assertInstanceOf(EntityCategory::class, $response);
        self::assertDatabaseHas('categories', [
            'name' => $entityCategory->name
        ]);
    }

    public function testFindById()
    {
        $categoryModel = ModelCategory::factory()->create();
        $response = $this->repository->findById($categoryModel->id);

        self::assertInstanceOf(EntityCategory::class, $response);
        self::assertEquals($categoryModel->id, $response->id());
    }

    public function testFindByIdNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->repository->findById('fake');
    }

    public function testFindAll()
    {
        $categories = ModelCategory::factory()->count(10)->create();
        $response = $this->repository->findAll();

        self::assertCount(count($categories), $response);
    }

}
