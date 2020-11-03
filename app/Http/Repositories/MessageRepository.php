<?php


namespace App\Http\Repositories;


use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class MessageRepository extends Repository
{
    protected $id;

    /**
     * MessageRepository constructor.
     *
     * @param Message $model
     */
    public function __construct(Message $model)
    {
        parent::__construct($model);
    }

    /**
     * @param mixed $id
     * @return MessageRepository
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }


    public function getDevices()
    {
        return DB::table($this->model->getTable(), 'm')
            ->select(
                [
                    'm.id',
                    'm.title',
                    'm.body',
                    'm.language',
                    'm.send_at',
                    'd.token',
                    'd.country',
                    'd.app_id',
                    'd.app_version',
                    'd.identifier',
                    'd.type',
                    'd.time_zone',
                ])
            ->join('application_messages as am', function ($join) {
                $join->on('m.id', '=', 'am.message_id');
            })
            ->join('devices as d', function ($join) {
                $join->on('am.app_id', '=', 'd.app_id');
            })
            ->whereBetween(
                'm.send_at',
                [
                    Carbon::now()->format('Y-m-d H:i:00'),
                    Carbon::now()->format('Y-m-d H:i:59')
                ]
            )
            ->where('am.status', '=', 'pending')
            ->where('m.is_active', '=', 1)
            ->whereRaw('m.language=d.language')
            ->orderBy('m.send_at');
    }

    public function setStatus($status)
    {
        return DB::table($this->model->getTable(), 'm')
            ->join('application_messages as am', function ($join) {
                $join->on('m.id', '=', 'am.message_id');
            })
            ->where('m.id', '=', $this->id)
            ->update(['am.status' => $status]);
    }
}
