<?php

namespace App\Repositories\Eloquent;

use App\Models\Category as ModelCategory;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;

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
        if (!$categoryDB = $this->modelCategory->find($category->id())) {
            throw new NotFoundException('Category Not Found');
        }

        $categoryDB->update([
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->isActive,
        ]);

        $categoryDB->refresh();

        return $this->toCategory($categoryDB);
    }

    public function delete(string $id): bool
    {
        if (!$categoryDB = $this->modelCategory->find($id)) {
            throw new NotFoundException('Category Not Found');
        }

        return $categoryDB->delete();
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
        $query = $this->modelCategory;
        if ($filter) {
            $query->where('name', 'LIKE', "%{$filter}%");
        }

        $query->orderBy('id', $order);
        $paginator = $query->paginate();

        return new PaginationPresenter($paginator);
    }

    private function toCategory(Object $object): EntityCategory
    {
        $entityCategory = new EntityCategory(
            id: $object->id,
            name: $object->name,
            description: $object->description,
        );

        $object->is_active ? $entityCategory->activate() : $entityCategory->disable();

        return $entityCategory;
    }
}
