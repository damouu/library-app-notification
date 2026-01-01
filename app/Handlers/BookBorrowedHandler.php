<?php

namespace App\Handlers;

use App\Mail\BookBorrowedMail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;
use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;

class BookBorrowedHandler
{
    /**
     * @throws Exception
     */
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        $body = $message->getBody();
        $headers = $message->getHeaders() ?? [];

        $memberCardUUID = $body['metadata']['memberCardUUID'] ?? null;

        $notificationData = $body['data']['notification_data'] ?? [];

        $parentContext = TraceContextPropagator::getInstance()->extract($headers);
        $tracer = Globals::tracerProvider()->getTracer('notification-service');

        $span = $tracer->spanBuilder('kafka_consume_user')
            ->setParent($parentContext)
            ->startSpan();

        $scope = $span->activate();

        try {
            $span->setAttribute('user.member_card_uuid', $memberCardUUID);

            $dbSpan = $tracer->spanBuilder('database_fetch_user')->startSpan();

            try {
                $user = User::where('card_uuid', $memberCardUUID)->first();
                if (!$user) {
                    Log::warning("User not found for UUID: {$memberCardUUID}. Skipping notification.");
                    return;
                }
                $dbSpan->setAttribute('db.user_id', $user->id);
            } finally {
                $dbSpan->end();
            }

            $mailSpan = $tracer->spanBuilder('send_registration_email')->startSpan();

            try {
                Mail::to($user->email)->send(new BookBorrowedMail($notificationData));
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
