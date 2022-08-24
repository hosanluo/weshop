<?php

namespace WechatShop\Application;

use EasyWeChat\Kernel\ServiceContainer;

/**
 * Application
 *
 * @property \WechatShop\Application\Account\Client             $account
 * @property \WechatShop\Application\Aftersale\Client           $aftersale
 * @property \WechatShop\Application\Coupon\Client              $coupon
 * @property \WechatShop\Application\Delivery\Client            $delivery
 * @property \WechatShop\Application\Order\Client               $order
 * @property \WechatShop\Application\Promoter\Client            $promoter
 * @property \WechatShop\Application\Register\Client            $register
 * @property \WechatShop\Application\Spu\Client                 $spu
 * @property \WechatShop\Application\AccessToken\AccessToken    $accessToken
 */
class Application extends ServiceContainer
{
    protected $providers = [
        Account\ServiceProvider::class,
        Aftersale\ServiceProvider::class,
        Coupon\ServiceProvider::class,
        Delivery\ServiceProvider::class,
        Order\ServiceProvider::class,
        Promoter\ServiceProvider::class,
        Register\ServiceProvider::class,
        Spu\ServiceProvider::class,
        AccessToken\ServiceProvider::class
    ];
}
