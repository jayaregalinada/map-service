<?php

namespace App\Facades;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Services\Detail\Providers\BaseProvider;

/**
 * @method static \Services\Detail\Detail detail($id, array $parameters = [])
 * @method static \Services\Detail\Detail request(string|mixed $id, Request $request)
 * @method static BaseProvider provider(string|null $provider = null)
 * @see \Services\Detail\Manager
 * @see \Services\Detail\Repository
 */
class Detail extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return 'detail';
    }
}
