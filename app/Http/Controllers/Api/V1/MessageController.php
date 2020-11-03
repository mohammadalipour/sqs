<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DeviceRepository;
use App\Http\Repositories\MessageRepository;
use App\Jobs\QueueMessages;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }


    public function index()
    {
        return $this->dispatchNow(new QueueMessages());
    }
}
