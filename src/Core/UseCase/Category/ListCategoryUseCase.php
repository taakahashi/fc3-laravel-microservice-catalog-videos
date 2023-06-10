<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\CategoryListInputDTO;
use Core\UseCase\DTO\Category\CategoryListOutputDTO;

class ListCategoryUseCase
{
    protected CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryListInputDTO $input): CategoryListOutputDTO
    {
        $newCategory = $this->repository->findById($input->id);

        return new CategoryListOutputDTO (
            id: $newCategory->id(),
            name: $newCategory->name,
            description: $newCategory->description,
            is_active: $newCategory->isActive,
            created_at: $newCategory->createdAt(),
        );
    }

}
