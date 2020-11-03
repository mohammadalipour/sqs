<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Repositories\DeviceRepository;
use App\Http\Requests\Api\ApiController;
use App\Http\Requests\Api\V1\RegisterDeviceRequest;
use App\Http\Resources\Api\V1\DeviceResource;
use Exception;

class DeviceController extends ApiController
{
    private $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    public function register(RegisterDeviceRequest $request)
    {
        $request->validated();

        try {
            $attributes = $request->all();
            $this->deviceRepository->create($attributes);

            $response = new DeviceResource([]);
            $this->setData($response);

            return $this->successResponse(trans('api.success_response'));
        } catch (Exception $exception) {
            report($exception);

            return $this->failResponse(trans('api.fail_response'));
        }
    }
}
