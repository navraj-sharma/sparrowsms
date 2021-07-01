<?php

namespace NavrajSharma\SparrowSMS\Exceptions;

use Exception;

class SparrowSMSError extends \Exception
{
    /**
     * Thrown when we're unable to communicate with sparrowsms.
     *
     * @param Exception $exception
     *
     * @return SparrowSMSError
     */
    public static function SparrowSMSConnectionError(Exception $exception): self
    {
        return new static("Sparrow SMS Error: {$exception->getMessage()}", $exception->getCode(), $exception);
    }
}
