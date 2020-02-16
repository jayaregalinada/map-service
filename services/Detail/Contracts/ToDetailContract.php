<?php

namespace Services\Detail\Contracts;

use Services\Detail\Detail;

interface ToDetailContract
{
    public function toDetail() : Detail;
}
