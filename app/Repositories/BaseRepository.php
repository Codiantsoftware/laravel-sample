<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
     * Eloquent Model
     *
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model dependency of model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Create a specific resource
     *
     * @param array $attributes [all the required parameter for creating a record]
     *
     * @return Model
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

        
    /**
     * Method getAll
     *
     * @return collection
     */
    public function getAll()
    {
        return $this->model->get();
    }

    /**
     * Get all record with some condition
     *
     * @param array $where [Pass parameter for where condition]
     * @param array $with  [Relation attribute]
     *
     * @return Collection
     */
    public function getAllWhere(array $where, $with = [])
    {
        return $this->model->with($with)->where($where)->get();
    }

    /**
     * Method update or create
     *
     * @param array $where      [Pass parameter for where condition]
     * @param array $attributes [Required parameter for creating/updating a record]
     *
     * @return bool
     */
    public function updateOrCreate(array $where, array $attributes)
    {
        return $this->model->updateOrCreate($where, $attributes);
    }

    /**
     * Method first or create
     *
     * @param array $where      [Pass parameter for where condition]
     * @param array $attributes [Required parameter for creating a record]
     *
     * @return Model
     */
    public function firstOrCreate(array $where, array $attributes)
    {
        return $this->model->firstOrCreate($where, $attributes);
    }

    /**
     * Get First selected row
     *
     * @param array $where [Pass parameter for where condition]
     *
     * @return Object
     */
    public function firstWhere(array $where):? Object
    {
        return $this->model->where($where)->first();
    }

    /**
     * Update Specified resource
     *
     * @param array $data  [Required parameter for updating a record]
     * @param int   $id    [Id for update the record]
     * @param Model $model [Model object]
     *
     * @return Model
     */
    public function update(array $data, int $id, ?Model $model = null): Model
    {
        $model ??= $this->model->find($id);
        if ($model) {
            $isUpdated = $model->update($data);
            if ($isUpdated) {
                $model = $this->model->find($id);
            }
        }

        return $model;
    }

    /**
     * Method findWith
     *
     * @param int   $id   [Id for get the record]
     * @param array $with [Relation attribute]
     *
     * @return Object
     */
    public function findWith(int $id, array $with = [])
    {
        return $this->model->with($with)->where(['id' => $id])->first();
    }

    /**
     * Method deleteWhere
     *
     * @param $id $id [Id for delete the record]
     *
     * @return void
     */
    public function deleteWhere($id)
    {
        return $this->model->destroy($id);
    }
}
