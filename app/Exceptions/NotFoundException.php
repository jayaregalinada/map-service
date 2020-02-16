<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundException extends NotFoundHttpException
{
    /**
     * NotFoundException constructor.
     *
     * @param null|string $message
     */
    public function __construct($message = null)
    {
        parent::__construct($message ?? __('exceptions.not_found'));
    }
}
