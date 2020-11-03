<?php

namespace App\Jobs;

use App\Http\Repositories\MessageRepository;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Psr\SimpleCache\InvalidArgumentException;

class QueueMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param MessageRepository $messageRepository
     * @return bool
     * @throws InvalidArgumentException
     */
    public function handle(MessageRepository $messageRepository)
    {
        try {
            do {
                //Get all devices that message must be sending for it at this moment
                $devices = $messageRepository->getDevices()->paginate(500);

                foreach ($devices as $device) {
                    //it would cache information of devices on Redis to send those by NodeJs
                    cache()->set($device->token, json_encode($device));
                }

            } while ($devices->lastItem() === $devices->total());

            return true;
        } catch (Exception $exception) {
            report($exception);
        }
    }
}
