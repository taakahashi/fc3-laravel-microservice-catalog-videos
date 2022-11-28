<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesInputDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function index(Request $request, ListCategoriesUseCase $useCase): AnonymousResourceCollection
    {
        $response = $useCase->execute(
            input: new ListCategoriesInputDTO(
                filter: $request->get('filter'),
                order: $request->get('order'),
                page: (int) $request->get('page'),
                totalPage: (int) $request->get('totalPage')
            )
        );

        return CategoryResource::collection(collect($response->items))->additional([
            'meta' => [
                'total' => $response->total,
                'current_page' => $response->current_page,
                'first_page' => $response->first_page,
                'last_page' => $response->last_page,
                'per_page' => $response->per_page,
                'to' => $response->to,
                'from' => $response->from
            ]
        ]);
    }
}
