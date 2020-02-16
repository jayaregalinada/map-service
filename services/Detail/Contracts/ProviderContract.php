<?php

namespace Services\Detail\Contracts;

use Services\Detail\Detail;

interface ProviderContract
{
    /**
     * @param string|mixed $id
     * @param array        $parameters
     *
     * @return \Services\Detail\Detail
     */
    public function detail($id, array $parameters = []) : Detail;
}
