<?php


namespace Tests\Feature;

use App\Models\Article;
use App\Services\ArticleService;
use Tests\TestCase;

class ArticleServiceTest extends TestCase
{

    public function test_it_can_create_article()
    {
        $data = [
            'title' => $this->faker->sentence,
            'content_article' => $this->faker->paragraph
        ];

        $service = app()->make(ArticleService::class);

        $result = $service->store($data);
        $this->assertInstanceOf(Article::class, $result);
        $this->assertDatabaseHas('articles', ['title' => $data['title']]);
    }
}
