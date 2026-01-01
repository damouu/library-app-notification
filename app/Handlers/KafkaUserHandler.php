<?php

namespace App\Handlers;

use App\Mail\UserRegisterMail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;
use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;

class KafkaUserHandler
{
    /**
     * @throws Exception
     */
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        $body = $message->getBody();
        $headers = $message->getHeaders() ?? [];


        $parentContext = TraceContextPropagator::getInstance()->extract($headers);
        $tracer = Globals::tracerProvider()->getTracer('notification-service');


        $span = $tracer->spanBuilder('kafka_consume_user')
            ->setParent($parentContext)
            ->startSpan();

        $scope = $span->activate();

        $cardUuid = data_get($body, 'metadata.memberCardUUID') ?: data_get($body, 'memberCardUUID');

        $email = data_get($body, 'user_email') ?: "test-user-{$cardUuid}@example.com";

        try {
            $span->setAttribute('user.member_card_uuid', $body['memberCardUUID'] ?? 'unknown');

            $dbSpan = $tracer->spanBuilder('database_insert_user')
                ->startSpan();
            try {
                $user = User::firstOrCreate(
                    ['card_uuid' => $cardUuid],
                    ['email' => $email]
                );
                $dbSpan->setAttribute('db.user_id', $user->id);

            } catch (Exception $e) {
                $span->recordException($e);
                Log::error("Database error in notification worker", ['error' => $e->getMessage()]);
                throw $e;
            } finally {
                $dbSpan->end();
            }

            $mailSpan = $tracer->spanBuilder('send_registration_email')
                ->startSpan();
            try {
                Mail::to($user->email)->send(new UserRegisterMail('dede' ?? 'Unknown Book'));
                $mailSpan->setAttribute('mail.recipient', $user->email);
            } finally {
                $mailSpan->end();
            }

            Log::info("Kafka Process Completed Successfully!");

        } catch (Exception $e) {
            $span->recordException($e);
            throw $e;
        } finally {
            $span->end();
            $scope->detach();
            Globals::tracerProvider()->forceFlush();
        }
    }
}
