<?php

namespace App\Console\Commands;

use App\Handlers\CatalogHandler;
use App\Tracing\KafkaTracingMiddleware;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Junges\Kafka\Exceptions\ConsumerException;
use Junges\Kafka\Facades\Kafka;

class ConsumeCatalogEvents extends Command
{
    protected $signature = 'kafka:consume-catalog';
    protected $description = 'Consume catalog events from Kafka';

    /**
     * @throws Exception
     * @throws ConsumerException
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        $consumer = Kafka::consumer(['library.catalog.v1'])
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
            ->withHandler($this->laravel->make(CatalogHandler::class))
            ->withMiddleware(KafkaTracingMiddleware::class)
            ->build();
        $consumer->consume();
    }
}
