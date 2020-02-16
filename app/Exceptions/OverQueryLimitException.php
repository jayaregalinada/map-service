<?php

namespace App\Exceptions;

use RuntimeException;

class OverQueryLimitException extends RuntimeException
{
    /**
     * OverQueryLimitException constructor.
     *
     * @param null|string $message
     */
    public function __construct($message = null)
    {
        parent::__construct($message ?? __('exceptions.over_limit_quota'));
    }
}
