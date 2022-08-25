<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:04
 */

namespace WechatShop;


use WechatShop\Kernel\Support\Str;

/**
 * CLass Factory
 *
 * @method static \WechatShop\Application\Account\Client        account(array $config)
 *  @method static \WechatShop\Application\Aftersale\Client     aftersale(array $config)
 * @method static \WechatShop\Application\Coupon\Client         coupon(array $config)
 * @method static \WechatShop\Application\Delivery\Client       delivery(array $config)
 * @method static \WechatShop\Application\Order\Client          order(array $config)
 * @method static \WechatShop\Application\Promoter\Client       promoter(array $config)
 * @method static \WechatShop\Application\Register\Client       register(array $config)
 * @method static \WechatShop\Application\Spu\Client            spu(array $config)
 *
 */
class WeShop
{

    public static function make($name, $config)
    {
        $namespace = Str::studly($name);

        $application = "\\WechatShop\\Application\\{$namespace}\\Client";
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
