<?php


namespace Tests\Feature;

use Tests\TestCase;

class ArticleApiUnitTest extends TestCase
{
    public function test_it_can_create_an_article()
    {
        $data = [
            'title' => $this->faker->sentence,
            'content_article' => $this->faker->paragraph
        ];

        $response = $this->post(route('articles.store'), $data);

        $response
            ->assertStatus(201)
            ->assertJson($data);

        $this->assertDatabaseHas('articles', ['title' => $data['title']]);
    }
}
