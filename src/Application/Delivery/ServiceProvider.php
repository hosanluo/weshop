<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:45
 */

namespace WechatShop\Application\Delivery;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        !isset($app['delivery']) && $app['delivery'] = function ($app) {
            return new Client($app);
        };
    }
}
