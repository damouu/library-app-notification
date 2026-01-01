<?php

namespace App\Console\Commands;

use App\Handlers\BookReturnedHandler;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Exceptions\ConsumerException;
use Junges\Kafka\Facades\Kafka;

class ConsumeReturnEvents extends Command
{
    protected $signature = 'kafka:consume-return';
    protected $description = 'Consume return events from Kafka';

    /**
     * @throws Exception
     * @throws ConsumerException
     */
    public function handle(): void
    {
        $consumer = Kafka::consumer(['library.return.v1'])
            ->withConsumerGroupId(config('kafka.consumer_group_id'))
            ->withHandler(new BookReturnedHandler())
            ->build();

        $consumer->consume();
    }
}
