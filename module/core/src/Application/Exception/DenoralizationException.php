<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Ergonode\Core\Application\Exception;

class DenoralizationException extends NormalizerException
{
    public function __construct(string $message, \Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
