<?php

namespace App\Tracing;

use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\Middleware;
use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;
use OpenTelemetry\API\Trace\StatusCode;
use Throwable;

class KafkaTracingMiddleware implements Middleware
{
    /**
     * @throws Throwable
     */
    public function __invoke(ConsumerMessage $message, callable $next): void
    {
        $headers = $message->getHeaders() ?? [];

        $parentContext = TraceContextPropagator::getInstance()->extract($headers);

        $tracer = Globals::tracerProvider()->getTracer('notification-service');

        $span = $tracer
            ->spanBuilder('kafka.consume')
            ->setParent($parentContext)
            ->startSpan();

        $scope = $span->activate();

        try {
            $span->setAttribute('messaging.system', 'kafka');
            $span->setAttribute('messaging.operation', 'process');
            $span->setAttribute('messaging.destination.name', $message->getTopicName() ?? 'unknown');
            $span->setAttribute('messaging.kafka.partition', $message->getPartition());
            $span->setAttribute('messaging.kafka.offset', $message->getOffset());

            if ($message->getKey() !== null) {
                $span->setAttribute('messaging.message.id', (string)$message->getKey());
            }

            $next($message, $next);
        } catch (Throwable $e) {
            $span->recordException($e);
            $span->setStatus(StatusCode::STATUS_ERROR);

            throw $e;
        } finally {
            $scope->detach();
            $span->end();

            Globals::tracerProvider()->forceFlush();
        }
    }
}
