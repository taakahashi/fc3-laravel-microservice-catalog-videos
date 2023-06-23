<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $endpoint = '/api/categories';

    public function testListEmptyCategories()
    {
        $response = $this->getJson($this->endpoint);

        $response->assertStatus(200);
    }
}
