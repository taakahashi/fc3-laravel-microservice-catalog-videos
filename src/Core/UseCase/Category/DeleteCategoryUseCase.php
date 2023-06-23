<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\CategoryListInputDTO;
use Core\UseCase\DTO\Category\DeleteCategory\CategoryDeleteOutputDTO;

class DeleteCategoryUseCase
{
    protected CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryListInputDTO $input): CategoryDeleteOutputDTO
    {
        $response = $this->repository->delete($input->id);

        return new CategoryDeleteOutputDto(
            success: $response
        );
    }
}
