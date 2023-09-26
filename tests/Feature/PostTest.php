<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    // Telling the test file to use our database migrations
    use DatabaseMigrations;

    public function test_getAll_success(): void
    {
        // $this->get sends a get request to the given URL and captures the response
        $response = $this->get('/api/posts');

        // Asserting that response has a 200 (success) status code
        $response->assertStatus(200);
    }
}
