<?php

namespace App\Console\Commands;

use App\Handlers\BookBorrowedHandler;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Exceptions\ConsumerException;
use Junges\Kafka\Facades\Kafka;

class ConsumeBorrowEvents extends Command
{
    protected $signature = 'kafka:consume-borrow';
    protected $description = 'Consume borrows events from Kafka';

    /**
     * @throws Exception
     * @throws ConsumerException
     */
    public function handle(): void
    {
        $consumer = Kafka::consumer(['library.borrow.v1'])
            ->withConsumerGroupId(env('KAFKA_CONSUMER_GROUP_ID', 'notification-borrow-group'))
            ->withHandler(new BookBorrowedHandler())
            ->build();

        $consumer->consume();
    }
}
