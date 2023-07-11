<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected string $endpoint = '/api/categories';

    public function testListEmptyCategories()
    {
        $response = $this->getJson($this->endpoint);

        $response->assertStatus(200);
        $this->assertEquals(0, $response['meta']['total']);
    }

    public function testListAllCategories()
    {
        Category::factory()->count(30)->create();
        $response = $this->getJson($this->endpoint);

        $response->assertStatus(200);
        $this->assertEquals(30, $response['meta']['total']);
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'first_page',
                'last_page',
                'per_page',
                'to',
                'from'
            ]
        ]);
    }

    public function testListPaginateCategories()
    {
        Category::factory()->count(30)->create();
        $response = $this->getJson("$this->endpoint?page=2");

        $response->assertStatus(200);
        $this->assertEquals(30, $response['meta']['total']);
        $this->assertEquals(2, $response['meta']['current_page']);
    }
}
