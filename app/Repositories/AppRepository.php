<?php

namespace App\Repositories;

use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class AppRepository implements AppRepositoryInterface
{
    protected $model;
    protected $originalModel;
    /**
     * PostRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->originalModel = $model;
        $this->makeModel();
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getFillable() {
        return $this->model->getFillable();
    }

    /**
     * @return Model
     */
    public function makeModel()
    {
        return $this->model = $this->originalModel;
    }

    public function resetModel()
    {
        $this->makeModel();
    }
    /**
     * @param array $columns
     * @param int $offset
     *
     * @return Collection
     */
    public function fetchList(array $columns = ['*'], $offset = 0)
    {
        $perPage = config('common.item_per_page');
        $result = $this->model
            ->skip($offset)
            ->limit($perPage)
            ->get($columns);
        $this->resetModel();
        return $result;
    }

    /**
     * @param $id
     * @param array $columns
     *
     * @return object|null
     */
    public function forceFindById($id, array $columns = ['*'])
    {
        $result = $this->model->withTrashed()
            ->find($id, $columns);

        $this->resetModel();

        return $result;
    }
    /**
     * @param $id
     * @param array $columns
     *
     * @return object|null
     */
    public function findById($id, array $columns = ['*'])
    {
        $result = $this->model
            ->find($id, $columns);

        $this->resetModel();

        return $result;
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @param array $data
     *
     * @return int
     */
    public function update($id, array $data)
    {
        return $this->model
            ->where('id', $id)
            ->update($data);
    }

    /**
     * @param array $data
     *
     * @return boolean
     */
    public function delete(array $data)
    {
        return $this->model
            ->whereIn('id', $data)
            ->delete();
    }

    /**
     * @param array $columns
     *
     * @return boolean
     */
    public function fetchAll(array $columns = ['*'])
    {
        return $this->model->get($columns);
    }

    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    public function firstOrCreate(array $data, $dataCreate = [])
    {
        return $this->model->firstOrCreate($data, $dataCreate);
    }

    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }
    /**
     * @param null $page
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginateList($page = null, array $columns = ['*'])
    {
        $perPage = config('common.item_per_page');

        return $this->model
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage, $columns, 'page', $page);
    }

    /**
     * @param null $page
     * @param array $columns
     * @param int $perPage
     * @return mixed
     */
    public function paginateListWithPerPage($page = null, $perPage = 10, array $columns = ['*'])
    {
        return $this->model
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage, $columns, 'page', $page);
    }

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function firstWhere(array $where, $columns = ['*'])
    {
        $this->applyConditions($where);
        $result = $this->model->select($columns)->first();
        $this->resetModel();
        return $result;
    }

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */

    public function findWhere(array $where, $columns = ['*'])
    {
        $this->applyConditions($where);
        $result = $this->model->select($columns)->get();
        $this->resetModel();
        return $result;
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function countWhere(array $where)
    {
        $this->applyConditions($where);
        $result = $this->model->count();
        $this->resetModel();
        return $result;
    }

    /**
     * @param $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        return $this->model->whereIn($field, $values)->get($columns);
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     * @return void
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;

                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    /**
     * @param array $data
     * @param array $where
     * @return mixed|void
     */
    public function updateWhere(array $data, array $where)
    {
        $object = $this->firstWhere($where);
        if (!$object) {
            return false;
        }

        return $this->update($object->id, $data);
    }

    public function deleteWhere(array $where, $forceDelete = false)
    {
        $this->applyConditions($where);
        if ($forceDelete) {
            $result = $this->model->forceDelete();
        } else {
            $result = $this->model->delete();
        }

        $this->resetModel();

        return $result;
    }

    /**
     * @param array $where
     * @param string $field
     * @param array $values
     * @param array $columns
     * @return mixed|void
     */
    public function findWhereInAndWhere(array $where, $field, array $values, $columns = ['*'])
    {
        $this->applyConditions($where);

        $query = $this->model->whereIn($field, $values);
        $result = $query->get($columns);

        $this->resetModel();

        return $result;
    }

    public function deleteWhereIn($field, array $data, $forceDelete = false)
    {
        $result = $this->model->whereIn($field, $data);
        if ($forceDelete) {
            $result->forceDelete();
        } else {
            $result->delete();
        }

        $this->resetModel();

        return $result;
    }

    public function updateWhereIn($field, array $data, array $update)
    {
        return $this->model
            ->whereIn($field, $data)
            ->update($update);
    }

}
