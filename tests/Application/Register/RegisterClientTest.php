<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/26
 * Time: 14:01
 */

namespace WechatShop\Tests\Application\Register;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class RegisterClientTest extends TestCase
{
    protected $config = [
        'access_token' => 'mock-access-token'
    ];

    public function testMethodApply()
    {
        $response = new Response(200, [], '{"errcode": 0, "errmsg": "ok"}');
        $client = $this->createMock(Client::class);
        $client->expects($this->any())
            ->method('request')
            ->with('POST', 'shop/register/apply')
            ->willReturn($response);
        $registerClient = m::mock(\WechatShop\Application\Register\Client::class, $this->config)->makePartial();
        $registerClient->allows()->getHttpClient()->andReturn($client);

        $this->assertInstanceOf('GuzzleHttp\Client', $client);
        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($registerClient->apply()));
    }

    public function testMethodCheck()
    {
        $response = new Response(200, [], '{"errcode": 0, "errmsg": "ok"}');
        $client = $this->createMock(Client::class);
        $client->expects($this->any())
            ->method('request')
            ->with('POST', 'shop/register/check')
            ->willReturn($response);

        $registerClient = m::mock(\WechatShop\Application\Register\Client::class, $this->config)->makePartial();
        $registerClient->allows()->getHttpClient()->andReturn($client);

        $this->assertInstanceOf('GuzzleHttp\Client', $client);
        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($registerClient->check()));
    }

    public function testMethodFinishAccessInfo()
    {
        $response = new Response(200, [], '{"errcode": 0, "errmsg": "ok"}');
        $client = $this->createMock(Client::class);
        $client->expects($this->any())
            ->method('request')
            ->with('POST', 'shop/register/finish_access_info')
            ->willReturn($response);
        $registerClient = m::mock(\WechatShop\Application\Register\Client::class, $this->config)->makePartial();
        $registerClient->allows()->getHttpClient()->andReturn($client);

        $this->assertInstanceOf('GuzzleHttp\Client', $client);
        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($registerClient->finishAccessInfo(1)));
    }

    public function testMethodApplyScene()
    {
        $response = new Response(200, [], '{"errcode": 0, "errmsg": "ok"}');
        $client = $this->createMock(Client::class);
        $client->expects($this->any())
            ->method('request')
            ->with('POST', 'shop/register/apply_scene')
            ->willReturn($response);
        $registerClient = m::mock(\WechatShop\Application\Register\Client::class, $this->config)->makePartial();
        $registerClient->allows()->getHttpClient()->andReturn($client);

        $this->assertInstanceOf('GuzzleHttp\Client', $client);
        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($registerClient->applyScene(1)));
    }
}
