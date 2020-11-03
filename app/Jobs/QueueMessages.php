<?php

namespace App\Jobs;

use App\Http\Repositories\MessageRepository;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class QueueMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param MessageRepository $messageRepository
     * @return bool
     */
    public function handle(MessageRepository $messageRepository)
    {
        try {
            //Fetch all Devices which would get messages received
            $messages = $messageRepository->getDevices();

            //Chunk data to cache on redis
            $result = $messages->chunk(500, function ($devices) {
                $key = 'message_' . $devices->first()->id;
                Cache::store('redis')->rememberForever($key, function () use ($devices) {
                    return $devices->toJson();
                });
            });

            //Get Identity of message to update its status to success
            $id = ($result) ? $messages->first()->id : 0;

            //Update status of message to success
            $messageRepository->setId($id)->setStatus('success');

            return true;
        } catch (Exception $exception) {
            report($exception);
        }
    }
}
