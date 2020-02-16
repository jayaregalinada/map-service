<?php

namespace App\Contracts;

interface RequestableContract
{
    /**
     * @return array
     */
    public function toRequest() : array;
}
