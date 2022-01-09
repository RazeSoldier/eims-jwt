<?php
/**
 * Author: RazeSoldier (razesoldier@outlook.com)
 * License: Apache-2.0
 */

namespace RazeSoldier\EIMS\Jwt;

use Illuminate\Support\ServiceProvider;

/**
 * lcobucci/jwt库在EIMS的初始化的地方
 */
class JWTServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(JWTService::class, function () {
            return new JWTService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
