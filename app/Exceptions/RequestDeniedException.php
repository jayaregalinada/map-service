<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RequestDeniedException extends HttpException
{
    /**
     * RequestDeniedException constructor.
     *
     * @param null|string $message
     */
    public function __construct($message = null)
    {
        parent::__construct(Response::HTTP_UNAUTHORIZED,
            $message ?? __('exceptions.request_denied'));
    }
}
