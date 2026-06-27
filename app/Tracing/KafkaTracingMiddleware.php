<?php

namespace App\Tracing;

use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\Middleware;
use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;
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

        $span = $tracer->spanBuilder('kafka.consume')
            ->setParent($parentContext)
            ->startSpan();

        $scope = $span->activate();

        try {
            $span->setAttribute('kafka.topic', $message->getTopicName() ?? 'unknown');
            $span->setAttribute('kafka.partition', $message->getPartition());
            $span->setAttribute('kafka.offset', $message->getOffset());

            $next($message, $next);

        } catch (Throwable $e) {
            $span->recordException($e);
            throw $e;

        } finally {
            $span->end();
            $scope->detach();
            Globals::tracerProvider()->forceFlush();
        }
    }
}
