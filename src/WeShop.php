<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:04
 */

namespace WechatShop;


/**
 * CLass Factory
 *
 * @method static \WechatShop\Application\Application       application(array $config)
// * @method static \WechatShop\Application\Aftersale\Application     aftersale(array $config)
// * @method static \WechatShop\Application\Coupon\Application        coupon(array $config)
// * @method static \WechatShop\Application\Delivery\Application      delivery(array $config)
// * @method static \WechatShop\Application\Order\Application         order(array $config)
// * @method static \WechatShop\Application\Promoter\Application      promoter(array $config)
// * @method static \WechatShop\Application\Register\Application      register(array $config)
// * @method static \WechatShop\Application\Spu\Application           spu(array $config)
 *
 */
class WeShop
{

    public static function make($name, $config)
    {
        $application = "\\WechatShop\\Application\\Application";
        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}
