<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/25
 * Time: 16:17
 */

namespace WechatShop\Tests;

use PHPUnit\Framework\TestCase;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;
use WechatShop\WeShop;

class WeShopTest extends TestCase
{

    protected $errorConfig = [
        'exception' => null
    ];

    protected $correctConfig = [
        'access_token' => 'mock-access-token'
    ];

    public function testClientAccount()
    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('base_client init error. invalid config');
//        $account = WeShop::account($this->errorConfig);

        $account = WeShop::account($this->correctConfig);
        $this->assertInstanceOf('WechatShop\Application\Account\Client', $account);
    }

    public function testClientAftersale()
    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('base_client init error. invalid config');
//        WeShop::aftersale($this->errorConfig);

        $aftersale = WeShop::aftersale($this->correctConfig);
        $this->assertInstanceOf('WechatShop\Application\Aftersale\Client', $aftersale);
    }

    public function testClientCoupon()
    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('base_client init error. invalid config');
//        WeShop::coupon($this->errorConfig);

        $coupon = WeShop::coupon($this->correctConfig);
        $this->assertInstanceOf('WechatShop\Application\Coupon\Client', $coupon);
    }

    public function testClientDelivery()
    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('base_client init error. invalid config');
//        WeShop::delivery($this->errorConfig);

        $delivery = WeShop::delivery($this->correctConfig);
        $this->assertInstanceOf('WechatShop\Application\Delivery\Client', $delivery);
    }

    public function testClientOrder()
    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('base_client init error. invalid config');
//        WeShop::order($this->errorConfig);

        $order = WeShop::order($this->correctConfig);
        $this->assertInstanceOf('WechatShop\Application\Order\Client', $order);
    }

    public function testClientPromoter()
    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('base_client init error. invalid config');
//        WeShop::promoter($this->errorConfig);

        $promoter = WeShop::promoter($this->correctConfig);
        $this->assertInstanceOf('WechatShop\Application\Promoter\Client', $promoter);
    }

    public function testClientSpu()
    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('base_client init error. invalid config');
//        WeShop::spu($this->errorConfig);

        $spu = WeShop::spu($this->correctConfig);
        $this->assertInstanceOf('WechatShop\Application\Spu\Client', $spu);
    }
}
