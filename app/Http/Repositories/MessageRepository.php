<?php


namespace App\Http\Repositories;


use App\Models\Device;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class MessageRepository extends Repository
{
    /**
     * MessageRepository constructor.
     *
     * @param Message $model
     */
    public function __construct(Message $model)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }


    public function getDevices()
    {
        return $this->model->belongsToMany(
            'App\Models\Device',
            'application_messages',
            'message_id',
            'app_id'
        )->whereBetween(
            'send_at',
            [
                Carbon::now()->format('Y-m-d H:i:00'),
                Carbon::now()->format('Y-m-d H:i:59')
            ]
        )->where('messages.language', '=', 'devices.language')
            ->where('is_active', '1');
    }
}
