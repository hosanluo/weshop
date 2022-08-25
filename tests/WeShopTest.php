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

    protected $config = [
        'exception' => null
    ];

    public function testClientAccount()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('base_client init error. invalid config');
        WeShop::account($this->config);
    }

    public function testClientAftersale()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('base_client init error. invalid config');
        WeShop::aftersale($this->config);
    }

    public function testClientCoupon()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('base_client init error. invalid config');
        WeShop::coupon($this->config);
    }

    public function testClientDelivery()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('base_client init error. invalid config');
        WeShop::delivery($this->config);
    }

    public function testClientOrder()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('base_client init error. invalid config');
        WeShop::order($this->config);
    }

    public function testClientPromoter()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('base_client init error. invalid config');
        WeShop::promoter($this->config);
    }

    public function testClientSpu()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('base_client init error. invalid config');
        WeShop::spu($this->config);
    }
}
