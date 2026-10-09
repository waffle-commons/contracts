<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Queue;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use Waffle\Commons\Contracts\Queue\Envelope;
use Waffle\Commons\Contracts\Queue\FailedMessage;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(FailedMessage::class)]
final class FailedMessageTest extends AbstractTestCase
{
    public function testKeepsTheFullEnvelopeTheReasonAndTheInstant(): void
    {
        $envelope = new Envelope(
            'msg-1',
            new SendInvoice('inv-42'),
            'invoices',
            new DateTimeImmutable('2026-10-09T09:00:00+00:00'),
            3,
            ['traceparent' => '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01'],
        );
        $failedAt = new DateTimeImmutable('2026-10-09T09:10:00+00:00');

        $failed = new FailedMessage($envelope, 'RuntimeException: the PDF renderer timed out', $failedAt);

        static::assertSame($envelope, $failed->envelope);
        static::assertSame('RuntimeException: the PDF renderer timed out', $failed->reason);
        static::assertSame($failedAt, $failed->failedAt);
    }
}
