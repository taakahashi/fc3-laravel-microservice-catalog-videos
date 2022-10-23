<?php

namespace App\Repositories\Presenters;

use Core\Domain\Repository\PaginationInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use stdClass;

class PaginationPresenter implements PaginationInterface
{
    protected array $items = [];

    public function __construct(
        protected LengthAwarePaginator $paginator
    )
    {
        $this->items = $this->resolveItems(
            items: $this->paginator->items()
        );
    }

    /**
     * @return stdClass[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function total(): int
    {
        return $this->paginator->total();
    }

    public function currentPage(): int
    {
        return $this->paginator->currentPage();
    }

    public function firstPage(): int
    {
        return $this->paginator->firstItem();
    }

    public function lastPage(): int
    {
        return $this->paginator->lastPage();
    }

    public function perPage(): int
    {
        return $this->paginator->perPage();
    }

    public function to(): int
    {
        return $this->paginator->firstItem();
    }

    public function from(): int
    {
        return $this->paginator->lastItem();
    }

    private function resolveItems(array $items)
    {
        $response = [];

        foreach ($items as $item) {
            $stdClass = new stdClass();

            foreach ($item->toArray() as $key => $value) {
                $stdClass->{$key} = $value;
            }

            $response[] = $stdClass;
        }

        return $response;
    }
}
