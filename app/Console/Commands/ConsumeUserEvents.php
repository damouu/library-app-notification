<?php

namespace App\Console\Commands;

use App\Handlers\UserHandler;
use App\Tracing\KafkaTracingMiddleware;
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
            ->withSasl(
                username: config('kafka.sasl.username'),
                password: config('kafka.sasl.password'),
                mechanisms: config('kafka.sasl.mechanisms'),
                securityProtocol: config('kafka.securityProtocol'),
            )
            ->withOptions([
                'ssl.ca.location' => config('kafka.ca_location'),
            ])
            ->withConsumerGroupId(config('kafka.consumer_group_id'))
            ->withHandler($this->laravel->make(UserHandler::class))
            ->withMiddleware(KafkaTracingMiddleware::class)
            ->build();

        $consumer->consume();
    }
}
