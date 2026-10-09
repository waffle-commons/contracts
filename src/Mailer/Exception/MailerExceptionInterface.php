<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Mailer\Exception;

use Throwable;

/**
 * A mail transport failure — the transport refused the email or could not be
 * reached ([QUEUE-03]).
 */
interface MailerExceptionInterface extends Throwable {}
