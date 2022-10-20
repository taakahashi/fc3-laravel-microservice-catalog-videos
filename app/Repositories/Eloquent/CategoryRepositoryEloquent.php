<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\Category as ModelCategory;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Repository\PaginationInterface;
use Core\Domain\Repository\CategoryRepositoryInterface;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Exception\NotFoundException;

class CategoryRepositoryEloquent implements CategoryRepositoryInterface
{
    protected $modelCategory;

    public function __construct(ModelCategory $modelCategory)
    {
        $this->modelCategory = $modelCategory;
    }

    public function insert(EntityCategory $entityCategory): EntityCategory
    {
        $category = $this->modelCategory->create([
            'id' => $entityCategory->id,
            'name' => $entityCategory->name,
            'description' => $entityCategory->description,
            'is_active' => $entityCategory->isActive,
            'created_at' => $entityCategory->createdAt
        ]);

        return $this->toCategory($category);
    }

    public function update(EntityCategory $category): EntityCategory
    {
        return new EntityCategory(
            name: '@ToDo'
        );
    }

    public function delete(string $id): bool
    {
        return true;
    }

    public function findById(string $id): EntityCategory
    {
        $category = $this->modelCategory->find($id);

        if (!$category) {
            throw new NotFoundException();
        }

        return $this->toCategory($category);

    }

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        /** @var Category $categories */
        $categories = $this->modelCategory
            ->where(
                function ($query) use ($filter) {
                    if ($filter) {
                        $query->where('name', 'LIKE', "%{$filter}%");
                    }
                })
            ->orderBy('id', $order)
            ->get();

        return $categories->toArray();
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface
    {
        return new PaginationPresenter();
    }

    private function toCategory(Object $object): EntityCategory
    {
        return new EntityCategory(
            id: $object->id,
            name: $object->name
        );
    }
}
