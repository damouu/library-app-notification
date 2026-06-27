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
            ->withConsumerGroupId(env('KAFKA_CONSUMER_GROUP_ID', 'notification-catalog-group'))
            ->withHandler($this->laravel->make(CatalogHandler::class))
            ->withMiddleware(KafkaTracingMiddleware::class)
            ->build();
        $consumer->consume();
    }
}
