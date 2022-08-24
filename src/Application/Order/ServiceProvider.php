<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:45
 */

namespace WechatShop\Application\Order;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        !isset($app['order']) && $app['order'] = function ($app) {
            return new Client($app);
        };
    }
}
