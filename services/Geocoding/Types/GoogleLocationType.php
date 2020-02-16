<?php

namespace Services\Geocoding\Types;

use MyCLabs\Enum\Enum;

/**
 * @method static GoogleLocationType ROOFTOP()
 * @method static GoogleLocationType RANGE_INTERPOLATED()
 * @method static GoogleLocationType RANGE()
 * @method static GoogleLocationType GEOMETRIC_CENTER()
 * @method static GoogleLocationType CENTER()
 * @method static GoogleLocationType APPROXIMATE()
 */
final class GoogleLocationType extends Enum
{
    /**
     * @var string
     */
    private const ROOFTOP = 'ROOFTOP';

    /**
     * @var string
     */
    private const RANGE_INTERPOLATED = 'RANGE_INTERPOLATED';

    /**
     * @var string
     */
    private const RANGE = self::RANGE_INTERPOLATED;

    /**
     * @var string
     */
    private const GEOMETRIC_CENTER = 'GEOMETRIC_CENTER';

    /**
     * @var string
     */
    private const CENTER = self::GEOMETRIC_CENTER;

    /**
     * @var string
     */
    private const APPROXIMATE = 'APPROXIMATE';
}
