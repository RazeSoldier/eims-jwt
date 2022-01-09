<?php
/**
 * Author: RazeSoldier (razesoldier@outlook.com)
 * License: Apache-2.0
 */

namespace RazeSoldier\EIMS\Jwt;

use Illuminate\Support\Facades\Facade;

class JWT extends Facade
{
    protected static function getFacadeAccessor()
    {
        return JWTService::class;
    }
}
