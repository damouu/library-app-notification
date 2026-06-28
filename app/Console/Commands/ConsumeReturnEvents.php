<?php

namespace App\Console\Commands;

use App\Handlers\BookReturnedHandler;
use App\Tracing\KafkaTracingMiddleware;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Junges\Kafka\Exceptions\ConsumerException;
use Junges\Kafka\Facades\Kafka;

class ConsumeReturnEvents extends Command
{
    protected $signature = 'kafka:consume-return';
    protected $description = 'Consume return events from Kafka';

    /**
     * @throws Exception
     * @throws ConsumerException|BindingResolutionException
     */
    public function handle(): void
    {
        $consumer = Kafka::consumer(['library.return.v1'])
            ->withConsumerGroupId(env('KAFKA_CONSUMER_GROUP_ID'))
            ->withHandler($this->laravel->make(BookReturnedHandler::class))
            ->withMiddleware(KafkaTracingMiddleware::class)
            ->build();

        $consumer->consume();
    }
}
