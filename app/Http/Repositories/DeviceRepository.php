<?php


namespace App\Http\Repositories;


use App\Models\Device;
use Illuminate\Database\Eloquent\Collection;

class DeviceRepository extends Repository
{
    /**
     * DeviceRepository constructor.
     *
     * @param Device $model
     */
    public function __construct(Device $model)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
