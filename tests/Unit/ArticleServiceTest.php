<?php


namespace Tests\Unit;


use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Services\ArticleService;
use Mockery;
use Tests\UnitTestCase;

class ArticleServiceTest extends UnitTestCase
{
    protected $articleRepository;
    protected $articleService;

    public function setUp() : void
    {
        $this->articleRepository = Mockery::mock(ArticleRepository::class);
        $this->articleService = $this->getMockBuilder(ArticleService::class)
            ->setConstructorArgs([
                $this->articleRepository
            ])
            ->setMethods()
            ->getMock();
        parent::setUp();
    }

    public function test_store_article_success()
    {
//        $this->articleRepository->shouldReceive('store')
//            ->once()
//            ->andReturn(true);
//
        $this->articleRepository->shouldReceive('storeData')
            ->once()
            ->andReturn(true);

        $result = $this->articleService->store(['title' => 'test article', 'content_article' => 'test content article']);
        $this->assertTrue($result);
    }
}
