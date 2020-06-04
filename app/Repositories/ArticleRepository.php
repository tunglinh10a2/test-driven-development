<?php

namespace App\Repositories;

use App\Repositories\AppRepository;
use App\Models\Article;

class ArticleRepository extends AppRepository implements ArticleRepositoryInterface
{
    public function __construct(Article $model)
    {
        parent::__construct($model);
    }

//    public function store(array $data)
//    {
//        return $this->model->create($data);
//    }
}
