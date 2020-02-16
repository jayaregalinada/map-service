<?php

namespace App\Exceptions;

use RuntimeException;

class UnknownErrorException extends RuntimeException
{
    /**
     * UnknownError constructor.
     *
     * @param null|string $message
     */
    public function __construct($message = null)
    {
        parent::__construct($message ?? __('exceptions.unknown_error'));
    }
}

