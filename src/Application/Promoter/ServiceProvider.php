<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:45
 */

namespace WechatShop\Application\Promoter;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        !isset($app['promoter']) && $app['promoter'] = function ($app) {
            return new Client($app);
        };
    }
}
