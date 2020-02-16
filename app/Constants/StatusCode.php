<?php

namespace App\Constants;

use MyCLabs\Enum\Enum;

/**
 * @method static StatusCode OK;
 * @method static StatusCode ZERO_RESULTS;
 * @method static StatusCode OVER_QUERY_LIMIT;
 * @method static StatusCode REQUEST_DENIED;
 * @method static StatusCode INVALID_REQUEST;
 * @method static StatusCode UNKNOWN_ERROR;
 * @method static StatusCode NOT_FOUND;
 */
final class StatusCode extends Enum
{
    private const OK = 'OK';

    private const ZERO_RESULTS = 'ZERO_RESULTS';

    private const OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';

    private const REQUEST_DENIED = 'REQUEST_DENIED';

    private const INVALID_REQUEST = 'INVALID_REQUEST';

    private const UNKNOWN_ERROR = 'UNKNOWN_ERROR';

    private const NOT_FOUND = 'NOT_FOUND';

    /**
     * @param string $status
     *
     * @return bool
     */
    public static function isStatusGood(string $status) : bool
    {
        return !in_array($status, [self::OK, self::ZERO_RESULTS], true);
    }

    /**
     * @param string $status
     *
     * @return bool
     */
    public static function isStatusOK(string $status) : bool
    {
        return $status === self::OK;
    }

    /**
     * @param string $status
     *
     * @return bool
     */
    public static function isStatusZeroResult(string $status) : bool
    {
        return $status === self::ZERO_RESULTS;
    }
}
