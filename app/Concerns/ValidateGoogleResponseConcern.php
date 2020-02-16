<?php

namespace App\Concerns;

use App\Constants\StatusCode;
use App\Exceptions\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use App\Exceptions\UnknownErrorException;
use App\Exceptions\RequestDeniedException;
use App\Exceptions\InvalidRequestException;
use App\Exceptions\OverQueryLimitException;

trait ValidateGoogleResponseConcern
{
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function validateResponse(ResponseInterface $response)
    {
        $message = $this->getMessageFromResponse($response->getBody());
        $status = $response->getBody()['status'];
        if (StatusCode::isStatusGood($status)) {
            switch ($status) {
                case StatusCode::REQUEST_DENIED()->getValue():
                    throw new RequestDeniedException($message);

                case StatusCode::INVALID_REQUEST()->getValue():
                    throw new InvalidRequestException($response
                    ->getBody(), $message);

                case StatusCode::OVER_QUERY_LIMIT()->getValue():
                    throw new OverQueryLimitException($message);

                case StatusCode::NOT_FOUND()->getValue():
                    throw new NotFoundException($message);

                case StatusCode::UNKNOWN_ERROR()->getValue():
                    throw new UnknownErrorException($message);
            }
        }
    }

    /**
     * @param $response
     *
     * @return string|null
     */
    protected function getMessageFromResponse($response) : ?string
    {
        return $response['error_message'] ?? null;
    }
}
