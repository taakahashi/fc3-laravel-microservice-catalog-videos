<?php

namespace Tests\Unit\App\Http\Controllers\Api;

use App\Http\Controllers\Api\CategoryController;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesOutputDTO;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function testIndex()
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('get')->andReturn('test');

        $mockOutputDTO = Mockery::mock(ListCategoriesOutputDTO::class, [
            [], 1, 1, 1, 1, 1, 1, 1
        ]);

        $mockUseCase = Mockery::mock(ListCategoriesUseCase::class);
        $mockUseCase->shouldReceive('execute')->andReturn($mockOutputDTO);

        $controller = new CategoryController();
        $response = $controller->index($mockRequest, $mockUseCase);

        static::assertIsObject($response->resource);
        static::assertArrayHasKey('meta', $response->additional);

        //Spies
        $mockUseCase = Mockery::spy(ListCategoriesUseCase::class);
        $mockUseCase->shouldReceive('execute')->andReturn($mockOutputDTO);

        $controller->index($mockRequest, $mockUseCase);

        $mockUseCase->shouldHaveReceived('execute');
        //Spies

        Mockery::close();
    }
}
