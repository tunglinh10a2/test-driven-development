<?php


namespace App\Services;


use App\Repositories\AppRepositoryInterface;
use App\Repositories\ArticleRepositoryInterface;

class ArticleService extends AppService
{
    protected $articleRepository;

    public function __construct(ArticleRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

//    public function store(array $data)
//    {
//        $this->repository->findById(1);
//
//        return $this->repository->storeData($data);
//        return $this->repository->store($data);
//    }
}
