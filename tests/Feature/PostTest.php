<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PostTest extends TestCase
{
    // Telling the test file to use our database migrations
    use DatabaseMigrations;

    public function test_getAll_success(): void
    {
        // 1) using the factory we created earlier to generate a single
        // test post in the database
        Post::factory()->create();

        // 2) $this->getJson sends a get request
        // And allows us to assert rules about the contents of the JSON
        $response = $this->getJson('/api/posts');

        // 3) Asserting that response has a 200 (success) status code
        $response->assertStatus(200)
            // 4) assertJson allows us to assert things about the json itself
            // We pass in a callback function that is given an AssertableJson object
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['data', 'message']) // Asserting that the json Data exactly has the properties data and message
                    ->has('data', 1, function (AssertableJson $json) {
                        // Here we have 'scoped' $json so we're looking at a single item within data
                        $json->hasAll(['id', 'title', 'content', 'featured_image', 'author', 'created_at', 'updated_at'])
                            // whereAllType asserts that all of the fields must be specific data types
                            ->whereAllType([
                                'id' => 'integer',
                                'title' => 'string',
                                'content' => 'string',
                                'featured_image' => 'string',
                                'created_at' => 'string',
                                'updated_at' => 'string'
                            ])
                            // Using has to scope into the author object
                            ->has('author', function (AssertableJson $json) {
                                $json->hasAll(['id', 'first_name', 'last_name'])
                                    ->whereAllType([
                                        'id' => 'integer',
                                        'first_name' => 'string',
                                        'last_name' => 'string'
                                    ]);
                            });
                    }); 
            });
    }
}
