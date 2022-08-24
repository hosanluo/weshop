<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:39
 */

namespace WechatShop\Tests;

use EasyWeChat\Factory;
use Mockery as m;
use Monolog\Test\TestCase;
use WechatShop\Application\Register\Client;
use WechatShop\Kernel\ServiceContainer;
use WechatShop\WeShop;

class WeShopTest extends TestCase
{
    protected $config = [
        'app_id'    => 'mock-app-id',
        'secret'    => 'mock-app-secret',
        'token'     => 'easywechat',
        'log' => [
            'level' => 'debug',
            'file'  => '/tmp/easywechat.log',
        ],
    ];

    public function testWeShopApplicationInstance()
    {
        $factory = m::mock(Factory::miniProgram($this->config)->access_token);
        $factory->allows()->getToken()->andReturn(json_decode('{"access_token":"ACCESS_TOKEN","expires_in":7200}', true));
        $this->assertSame(json_decode('{"access_token":"ACCESS_TOKEN","expires_in":7200}', true), $factory->getToken());
        $this->assertInstanceOf('WechatShop\Application\Register\Client', \WechatShop\WeShop::application($this->config)->register);
    }


    public function testRegisterApplicationMethod()
    {
        $register = m::mock(\WechatShop\WeShop::application($this->config)->register);
        $register->allows()->apply()->andReturn('{"errcode": 0, "errmsg": "ok"}');
        $this->assertSame('{"errcode": 0, "errmsg": "ok"}', $register->apply());
    }
}
