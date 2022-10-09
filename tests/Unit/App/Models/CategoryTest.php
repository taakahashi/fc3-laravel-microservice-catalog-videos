<?php

namespace Tests\Unit\App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

use function class_uses;
use function array_keys;

class CategoryTest extends TestCase
{

    private function model(): Model {
        return new Category();
    }

    public function testIfUseTraits()
    {
        $expectedTraits = [
            HasFactory::class,
            SoftDeletes::class
        ];
        $usedTraits = array_keys(class_uses($this->model()));

        self::assertEquals($expectedTraits, $usedTraits);
    }

    public function testFillables()
    {
        $expectedFillables = [
            'id',
            'name',
            'description',
            'is_active'
        ];
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
        $expectedCasts = [
            'id' => 'string',
            'is_active' => 'boolean',
            'deleted_at' => 'datetime'
        ];
        $usedCasts = $this->model()->getCasts();

        self::assertEquals($expectedCasts, $usedCasts);
    }
}
