<?php

namespace App\Console\Commands;

use App\Handlers\KafkaUserHandler;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Exceptions\ConsumerException;
use Junges\Kafka\Facades\Kafka;

class ConsumeUserEvents extends Command
{
    protected $signature = 'kafka:consume-users';
    protected $description = 'Consume user events from Kafka';

    /**
     * @throws Exception
     * @throws ConsumerException
     */
    public function handle(): void
    {
        $consumer = Kafka::consumer(['auth-create-topic'])
            ->withConsumerGroupId(config('notification-user-group'))
            ->withHandler(new KafkaUserHandler())
            ->build();

        $consumer->consume();
    }
}
