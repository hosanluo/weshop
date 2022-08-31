<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/29
 * Time: 17:30
 */

namespace WechatShop\Tests\Application\Order;

use GuzzleHttp\Psr7\Response;
use WechatShop\Application\Order\Client;
use PHPUnit\Framework\TestCase;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;
use WechatShop\WeShop;
use Mockery as m;

class OrderClientTest extends TestCase
{

    protected $config = [
        'access_token' => 'mock-access_token'
    ];

    public function testMethodCheck()
    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('Attribute "scene" can not be empty!');
//        WeShop::order($this->config)->check(false);

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/scene/check')
            ->willReturn($response);

        $orderClient = m::mock(Client::class)->makePartial();
        $orderClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($orderClient->check(123)));
    }

    public function testMethodAdd()
    {
        $params = [
            'create_time' => 'mock-create_time',
            'out_order_id' => 'mock-out_order_id',
            'openid' => 'mock-openid',
            'path' => 'mock-path',
            'scene' => 'mock-scene',
            'order_detail' => [
                'test' => 1,
                'product_infos' => [
                    [
                        'out_product_id' => 'mock-out_product_id',
                        'out_sku_id' => 'mock-out_sku_id',
                        'product_cnt' => 'mock-product_cnt',
                        'sale_price' => 'mock-sale_price',
                        'real_price' => 'mock-real_price',
                        'head_img' => 'mock-head_img',
                        'title' => 'mock-title',
                        'path' => 'mock-path',
                    ],
                ],
                'pay_info' => [
                    'pay_method_type' => 1,
                ],
                'price_info' => [
                    'test' => 1,
                    'order_price' => '123',
                    'freight' => 1
                ],
            ],
            'delivery_detail' => [
                'test' => '1',
                'delivery_type' => '1',
            ],
            'address_info' => [
                'test' => 1,
                'receiver_name' => 'mock-receiver_name',
                'detailed_address' => 'mock-detailed_address',
                'tel_number' => 'mock-tel_number',
            ],
        ];

//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('Attribute "tel_number" can not be empty!');
//        WeShop::order($this->config)->add($params);

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/order/add')
            ->willReturn($response);

        $orderClient = m::mock(Client::class)->makePartial();
        $orderClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($orderClient->add($params)));
    }

    public function testMethodPay()
    {
        $params = ['openid' => 'mock-openid', 'action_type' => 'mock-action_type'];

//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('Attribute "openid" can not be empty!');
//        WeShop::order($this->config)->pay($params);

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/order/pay')
            ->willReturn($response);

        $orderClient = m::mock(Client::class)->makePartial();
        $orderClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($orderClient->pay($params)));
    }

    public function testMethodGet()
    {
        $params = ['openid' => 'mock-openid'];

//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('Attribute "openid" can not be empty!');
//        WeShop::order($this->config)->get($params);

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/order/get')
            ->willReturn($response);

        $orderClient = m::mock(Client::class)->makePartial();
        $orderClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($orderClient->get($params)));
    }

    public function testMethodGetListByFinder()
    {
        $params = ['page' => 1, 'page_size' => 2];

//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('Attribute "page_size" can not be empty!');
//        WeShop::order($this->config)->getListByFinder($params);

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/order/get_list_by_finder')
            ->willReturn($response);

        $orderClient = m::mock(Client::class)->makePartial();
        $orderClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($orderClient->getListByFinder($params)));
    }

    public function testMethodGetListBySharer()
    {
        $params = ['page' => 1, 'page_size' => 2, 'sharer_openid' => 'mock-sharer_openid'];

//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('Attribute "page" can not be empty!');
//        WeShop::order($this->config)->getListBySharer($params);

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/order/get_list_by_sharer')
            ->willReturn($response);

        $orderClient = m::mock(Client::class)->makePartial();
        $orderClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($orderClient->getListBySharer($params)));
    }

    public function testMethodGetList()
    {
        $params = ['sort_order' => 'mock-sort_order', 'page' => 'mock-page', 'page_size' => 'mock-page_size'];

//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('Attribute "sort_order" can not be empty!');
//        WeShop::order($this->config)->getList(['sort_order' => 'mock-sort_order', 'page' => 1, 'page_size' => 123]);

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/order/get_list')
            ->willReturn($response);

        $orderClient = m::mock(Client::class)->makePartial();
        $orderClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($orderClient->getList($params)));
    }
}
