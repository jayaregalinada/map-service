<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidRequestException extends HttpException
{
    /**
     * @var array|\Psr\Http\Message\StreamInterface
     */
    protected $response;

    /**
     * InvalidRequestException constructor.
     *
     * @param array|\Psr\Http\Message\StreamInterface $response
     * @param null                                    $message
     */
    public function __construct($response, $message = null)
    {
        parent::__construct(Response::HTTP_BAD_REQUEST,
            $message ?? __('exceptions.invalid_request'));
        $this->response = $response;
    }

    /**
     * @return array|\Psr\Http\Message\StreamInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
