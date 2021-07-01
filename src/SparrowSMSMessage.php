<?php

namespace NavrajSharma\SparrowSMS;

class SparrowSMSMessage
{
    /**
     * Message body.
     *
     * @var string
     */
    public $body;

    public function __construct(string $body)
    {
        $this->body = $body;
    }
}
