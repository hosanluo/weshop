<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/26
 * Time: 14:01
 */

namespace WechatShop\Tests\Application\Account;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Mockery as m;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;

class AccountClientTest extends TestCase
{
    protected $config = [
        'access_token' => 'mock-access-token'
    ];

    public function testMethodGetCategoryList()
    {
        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $client = $this->createMock(Client::class);
        $client->expects($this->any())
            ->method('request')
            ->with('POST', 'shop/account/get_category_list')
            ->willReturn($response);

        $accountClient = m::mock(\WechatShop\Application\Account\Client::class, $this->config)->makePartial();
        $accountClient->allows()->getHttpClient()->andReturn($client);

        $this->assertInstanceOf('GuzzleHttp\Client', $client);
        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($accountClient->getCategoryList()));
    }

    public function testMethodGetBrandList()
    {
        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $client = $this->createMock(Client::class);
        $client->expects($this->any())
            ->method('request')
            ->with('POST', 'shop/account/get_brand_list')
            ->willReturn($response);

        $accountClient = m::mock(\WechatShop\Application\Account\Client::class, $this->config)->makePartial();
        $accountClient->allows()->getHttpClient()->andReturn($client);

        $this->assertInstanceOf('GuzzleHttp\Client', $client);
        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($accountClient->getBrandList()));
    }

    public function testMethodUpdateInfoThrowable()
    {
        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('Attribute "service_agent_type" can not be empty!');
//        $this->expectExceptionMessage('Attribute "default_receiving_address" can not be empty!');
//        $this->expectExceptionMessage('Attribute "default_receiving_address.receiver_name" can not be empty!');
//        $this->expectExceptionMessage('Attribute "default_receiving_address.detailed_address" can not be empty!');
//        $this->expectExceptionMessage('Attribute "default_receiving_address.tel_number" can not be empty!');
//        $this->expectExceptionMessage('Attribute "default_receiving_address.province" can not be empty!');
//        $this->expectExceptionMessage('Attribute "default_receiving_address.city" can not be empty!');
//        $this->expectExceptionMessage('Attribute "default_receiving_address.town" can not be empty!');

        $accountClient = m::mock(\WechatShop\Application\Account\Client::class, $this->config)->makePartial();
        $accountClient->updateInfo([
            'service_agent_type' => 'mock-service_agent_type',
            'default_receiving_address' => [
                'receiver_name' => 'mock-receiver_name',
                'detailed_address' => 'mock-detailed_address',
                'tel_number' => 'mock-tel_number',
                'province' => 'mock-province',
                'city' => 'mock-city',
//                'town' => 'mock-town',
            ]
        ]);
    }

    public function testMethodUpdateInfo()
    {
        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $client = $this->createMock(Client::class);
        $client->expects($this->any())
            ->method('request')
            ->with('POST', 'shop/account/update_info')
            ->willReturn($response);

        $accountClient = m::mock(\WechatShop\Application\Account\Client::class, $this->config)->makePartial();
        $accountClient->allows()->getHttpClient()->andReturn($client);

        $this->assertInstanceOf('GuzzleHttp\Client', $client);
        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($accountClient->updateInfo([
            'service_agent_type' => 'mock-service_agent_type',
            'default_receiving_address' => [
                'receiver_name' => 'mock-receiver_name',
                'detailed_address' => 'mock-detailed_address',
                'tel_number' => 'mock-tel_number',
                'province' => 'mock-province',
                'city' => 'mock-city',
                'town' => 'mock-town',
            ]
        ])));
    }

    public function testMethodGetInfo()
    {
        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $client = $this->createMock(Client::class);
        $client->expects($this->any())
            ->method('request')
            ->with('POST', 'shop/account/get_info')
            ->willReturn($response);

        $accountClient = m::mock(\WechatShop\Application\Account\Client::class, $this->config)->makePartial();
        $accountClient->allows()->getHttpClient()->andReturn($client);

        $this->assertInstanceOf('GuzzleHttp\Client', $client);
        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($accountClient->getInfo()));
    }
}
