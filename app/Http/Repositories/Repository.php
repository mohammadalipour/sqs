<?php


namespace App\Http\Repositories;


use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Model
    {
       return $this->model->create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }
}
