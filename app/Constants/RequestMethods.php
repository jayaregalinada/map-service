<?php

namespace App\Constants;

use MyCLabs\Enum\Enum;

/**
 * @method static RequestMethods GET;
 * @method static RequestMethods POST;
 */
final class RequestMethods extends Enum
{
    /**
     * @var string
     */
    private const GET = 'GET';

    /**
     * @var string
     */
    private const POST = 'POST';
}
