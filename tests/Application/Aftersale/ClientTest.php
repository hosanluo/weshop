<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/31
 * Time: 09:46
 */

namespace WechatShop\Tests\Application\Aftersale;

use GuzzleHttp\Psr7\Response;
use WechatShop\Application\Aftersale\Client;
use PHPUnit\Framework\TestCase;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;
use WechatShop\WeShop;
use Mockery as m;

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

    public function testMethodAddException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute "out_order_id" can not be empty!');
        WeShop::aftersale($this->config)->add([]);
    }

    public function testMethodAdd()
    {
        $params = [
            'out_order_id' => 'mock-out_order_id',
            'out_aftersale_id' => 'mock-out_aftersale_id',
            'path' => 'mock-out_aftersale_id',
            'refund' => 'mock-out_aftersale_id',
            'openid' => 'mock-out_aftersale_id',
            'type' => 'mock-out_aftersale_id',
            'create_time' => 'mock-out_aftersale_id',
            'status' => 'mock-out_aftersale_id',
            'finish_all_aftersale' => 'mock-finish_all_aftersale',
            'product_infos' => [
                [
                    'out_product_id' => 'mock-out_product_id',
                    'out_sku_id' => 'mock-out_sku_id',
                    'product_cnt' => 'mock-product_cnt',
                ]
            ],
        ];

        $this->guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/aftersale/add')
            ->willReturn($this->response);

        $aftersaleClient = m::mock(Client::class)->makePartial();
        $aftersaleClient->allows()->getHttpClient()->andReturn($this->guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($aftersaleClient->add($params)));
    }

    public function testMethodGet()
    {
        $this->guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/aftersale/get')
            ->willReturn($this->response);

        $aftersaleClient = m::mock(Client::class)->makePartial();
        $aftersaleClient->allows()->getHttpClient()->andReturn($this->guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($aftersaleClient->get('mock-openid')));
    }

    public function testMethodUpdateException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute "out_order_id" can not be empty!');
        WeShop::aftersale($this->config)->Update([]);
    }

    public function testMethodUpdate()
    {
        $params = [
            'out_order_id' => 'mock-out_order_id',
            'out_aftersale_id' => 'mock-out_aftersale_id',
            'openid' => 'mock-openid',
            'status' => 'mock-status',
            'finish_all_aftersale' => 'mock-finish_all_aftersale',
        ];

        $this->guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/aftersale/update')
            ->willReturn($this->response);

        $aftersaleClient = m::mock(Client::class)->makePartial();
        $aftersaleClient->allows()->getHttpClient()->andReturn($this->guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($aftersaleClient->update($params)));
    }
}
