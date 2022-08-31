<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/30
 * Time: 15:45
 */

namespace WechatShop\Tests\Application\Delivery;

use GuzzleHttp\Psr7\Response;
use WechatShop\Application\Delivery\Client;
use PHPUnit\Framework\TestCase;
use Mockery as m;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;
use WechatShop\WeShop;

class ClientTest extends TestCase
{
    protected $response;

    protected $guzzleClient;

    protected $config = ['access_token' => 'mock-access_token'];

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');
        $this->guzzleClient = $this->createMock(\GuzzleHttp\Client::class);

    }

    public function testMethodGetCompanyList()
    {
        $this->guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/delivery/get_company_list')
            ->willReturn($this->response);

        $client = m::mock(Client::class)->makePartial();
        $client->allows()->getHttpClient()->andReturn($this->guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($client->getCompanyList()));
    }

    public function testMethodSendException()
    {
        $params = [
            'openid' => 'mock-openid',
            'finish_all_delivery' => 'mock-finish_all_delivery',
            'delivery_type' => 1,
            'delivery_list' => [
                [
                    'delivery_id' => 1,
                    'waybill_id' => 1,
                    'product_info_list' => [
                        [
                            'out_product_id' => 1,
//                            'out_sku_id' => 1
                        ]
                    ]
                ]
            ]
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute "out_sku_id" can not be empty!');
        WeShop::delivery($this->config)->send($params);
    }

    public function testMethodSend()
    {
        $params = [
            'openid' => 'mock-openid',
            'finish_all_delivery' => 'mock-finish_all_delivery',
            'delivery_type' => 1,
            'delivery_list' => [
                [
                    'delivery_id' => 1,
                    'waybill_id' => 1,
                    'product_info_list' => [
                        [
                            'out_product_id' => 1,
                            'out_sku_id' => 1
                        ]
                    ]
                ]
            ]
        ];

        $this->guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/delivery/send')
            ->willReturn($this->response);

        $client = m::mock(Client::class)->makePartial();
        $client->allows()->getHttpClient()->andReturn($this->guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($client->send($params)));
    }

    public function testMethodRecieveException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute "openid" can not be empty!');
        WeShop::delivery($this->config)->recieve([]);
    }

    public function testMethodRecieve()
    {
        $params = ['openid' => 'mock-openid'];

        $this->guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/delivery/recieve')
            ->willReturn($this->response);

        $client = m::mock(Client::class)->makePartial();
        $client->allows()->getHttpClient()->andReturn($this->guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($client->recieve($params)));
    }
}
