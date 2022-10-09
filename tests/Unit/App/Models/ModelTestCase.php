<?php

namespace Tests\Unit\App\Models;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;
    abstract protected function traits(): array;
    abstract protected function fillables(): array;
    abstract protected function casts(): array;

    public function testIfUseTraits()
    {
        $expectedTraits = $this->traits();
        $usedTraits = array_keys(class_uses($this->model()));

        self::assertEquals($expectedTraits, $usedTraits);
    }

    public function testFillables()
    {
        $expectedFillables = $this->fillables();
        $usedFillables = $this->model()->getFillable();

        self::assertEquals($expectedFillables, $usedFillables);
    }

    public function testIncrementingIsFalse()
    {
        $category = $this->model();

        self::assertFalse($category->incrementing);
    }

    public function testHasCasts()
    {
        $expectedCasts = $this->casts();
        $usedCasts = $this->model()->getCasts();

        self::assertEquals($expectedCasts, $usedCasts);
    }
}
