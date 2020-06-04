<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface AppRepositoryInterface
{
    public function getModel();

    public function getFillable();

    public function makeModel();

    /**
     * @param array $columns
     * @param int $offset
     *
     * @return Collection
     */
    public function fetchList(array $columns = ['*'], $offset = 0);

    /**
     * @param $id
     * @param array $columns
     *
     * @return object|null
     */
    public function forceFindById($id, array $columns = ['*']);
    /**
     * @param $id
     * @param array $columns
     *
     * @return object|null
     */
    public function findById($id, array $columns = ['*']);

    /**
     * @param array $data
     *
     * @return int
     */
//    public function store(array $data);

    /**
     * @param $id
     * @param array $data
     *
     * @return int
     */
    public function update($id, array $data);

    /**
     * @param array $data
     *
     * @return boolean
     */
    public function delete(array $data);

    /**
     * @param array $columns
     *
     * @return boolean
     */
    public function fetchAll(array $columns = ['*']);

    public function insert(array $data);

    public function firstOrCreate(array $data,$dataCreate = []);
    /**
     * @param null $page
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginateList($page = null, array $columns = ['*']);

    /**
     * @param null $page
     * @param array $columns
     * @param int $perPage
     * @return mixed
     */
    public function paginateListWithPerPage($page = null, $perPage = 10, array $columns = ['*']);

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function firstWhere(array $where, $columns = ['*']);

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */

    public function findWhere(array $where, $columns = ['*']);
    public function countWhere(array $where);

    /**
     * @param $relations
     * @return mixed
     */
    public function with($relations);

    public function findWhereIn($field, array $values, $columns = ['*']);

    /**
     * @param array $data
     * @param array $where
     * @return mixed
     */
    public function updateWhere(array $data, array $where);

    public function deleteWhere(array $where, $forceDelete = false);
    public function findWhereInAndWhere(array $where, $field, array $values, $columns = ['*']);

    public function deleteWhereIn($field, array $data, $forceDelete = false);
    public function updateWhereIn($field, array $data, array $update);
}
