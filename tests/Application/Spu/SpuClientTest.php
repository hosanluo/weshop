<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/29
 * Time: 14:35
 */

namespace WechatShop\Tests\Application\Spu;

use GuzzleHttp\Psr7\Response;
use WechatShop\Application\Spu\Client;
use PHPUnit\Framework\TestCase;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;
use WechatShop\Kernel\Traits\HasHttpRequests;
use WechatShop\WeShop;
use Mockery as m;

class SpuClientTest extends TestCase
{
    protected $config = [
        'access_token' => 'mock-access_token'
    ];

    public function testMethodAdd()
    {
        $params = [
            'out_product_id' => 'mock-out_product_id',
            'title' => 'mock-title',
            'path' => 'mock_path',
            'direct_path' => 'mock-direct_path',
            'head_img' => ['mock_img'],
            'qualification_pics' => ['mock-qualification_pics'],
            'desc_info' => [ 'desc' => 'mock-desc', 'imgs' => ['mock-imgs']],
            'third_cat_id' => 'mock-third_cat_id',
            'brand_id' => 'mock-brand_id',
            'info_version' => 'mock-info_version',
            'skus' => [
                [
                    'out_product_id' => 'mock-out_product_id',
                    'out_sku_id' => 'mock-out_sku_id',
                    'thumb_img' => 'mock-thumb_img',
                    "sale_price" => 'mock-sale_price',
                    "market_price" => 'mock-market_price',
                    "stock_num" => 'mock-stock_num',
                    "sku_code" => "mock-sku_code",
                    "barcode" => "mock-barcode",
                    "sku_attrs" => [
                        [
                            'attr_key' => 'mock-attr_key',
                            'attr_value' => 'mock-attr_value'
                        ],
                    ]
                ]
            ],
            'scene_group_list' => [1]
        ];

//        $this->expectException(InvalidArgumentException::class);

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())->method('request')->willReturn($response);

        $spuClient = m::mock(Client::class)->makePartial();
        $spuClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($spuClient->add($params)));
    }

    public function testMethodDel()
    {
        $params = [
            'product_id' => 1,
            'out_product_id' => 0
        ];

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/spu/del')
            ->willReturn($response);

        $spuClient = m::mock(Client::class)->makePartial();
        $spuClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($spuClient->del($params)));
    }

    public function testMethodDelAudit()
    {
        $params = [
            'product_id' => 1,
            'out_product_id' => 0
        ];

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/spu/del_audit')
            ->willReturn($response);

        $spuClient = m::mock(Client::class)->makePartial();
        $spuClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($spuClient->del_audit($params)));
    }

    public function testMethodGet()
    {
        $params = [
            'out_product_id' => 'mock-out_product_id',
            'product_id' => 'mock-product_id',
            'need_edit_spu' => 'mock-need_edit_spu'
        ];

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/spu/get')
            ->willReturn($response);

        $spuClient = m::mock(Client::class)->makePartial();
        $spuClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($spuClient->get($params)));
    }

    public function testMethodGetList()
    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('Attribute "status" can not be empty!');
//        WeShop::spu($this->config)->getList([]);


        $params = [
            'status' => 'mock-status',
            'page' => 'mock-page',
            'page_size' => 'mock-page_size'
        ];

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/spu/get_list')
            ->willReturn($response);

        $spuClient = m::mock(Client::class)->makePartial();
        $spuClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($spuClient->getList($params)));
    }

    public function testMethodUpdate()
    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('Attribute "title" can not be empty!');
//        WeShop::spu($this->config)->update([], 1, 1);

        $params = [
            'out_product_id' => 'mock-out_product_id',
            'title' => 'mock-title',
            'path' => 'mock_path',
            'direct_path' => 'mock-direct_path',
            'head_img' => ['mock_img'],
            'qualification_pics' => ['mock-qualification_pics'],
            'desc_info' => [ 'desc' => 'mock-desc', 'imgs' => ['mock-imgs']],
            'third_cat_id' => 'mock-third_cat_id',
            'brand_id' => 'mock-brand_id',
            'info_version' => 'mock-info_version',
            'skus' => [
                [
                    'out_product_id' => 'mock-out_product_id',
                    'out_sku_id' => 'mock-out_sku_id',
                    'thumb_img' => 'mock-thumb_img',
                    "sale_price" => 'mock-sale_price',
                    "market_price" => 'mock-market_price',
                    "stock_num" => 'mock-stock_num',
                    "sku_code" => "mock-sku_code",
                    "barcode" => "mock-barcode",
                    "sku_attrs" => [
                        [
                            'attr_key' => 'mock-attr_key',
                            'attr_value' => 'mock-attr_value'
                        ],
                    ]
                ]
            ],
            'scene_group_list' => [1]
        ];

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/spu/update')
            ->willReturn($response);

        $spuClient = m::mock(Client::class)->makePartial();
        $spuClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($spuClient->update($params, 1, 2)));
    }

    public function testMethodListing()
    {
        $params = [
            'out_product_id' => 'mock-out_product_id',
            'product_id' => 'mock-product_id',
        ];

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/spu/listing')
            ->willReturn($response);

        $spuClient = m::mock(Client::class)->makePartial();
        $spuClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($spuClient->listing($params, 1, 2)));
    }

    public function testMethodDelisting()
    {
        $params = [
            'out_product_id' => 'mock-out_product_id',
            'product_id' => 'mock-product_id',
        ];

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/spu/delisting')
            ->willReturn($response);

        $spuClient = m::mock(Client::class)->makePartial();
        $spuClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($spuClient->delisting($params, 1, 2)));
    }

    public function testMethodUpdateWithoutAudit()
    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('Attribute skus.out_sku_id can not be empty!');
//        WeShop::spu($this->config)->updateWithoutAudit(['skus' => []], 1, 2);

        $params = [
            'out_product_id' => 'mock-out_product_id',
            'product_id' => 'mock-product_id',
            'skus' => [
                'out_sku_id' => 1
            ]
        ];

        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');

        $guzzleClient = $this->createMock(\GuzzleHttp\Client::class);
        $guzzleClient->expects(static::once())
            ->method('request')
            ->with('POST', 'shop/spu/update_without_audit')
            ->willReturn($response);

        $spuClient = m::mock(Client::class)->makePartial();
        $spuClient->allows()->getHttpClient()->andReturn($guzzleClient);

        $this->assertSame('{"errcode":0,"errmsg":"ok"}', json_encode($spuClient->updateWithoutAudit($params, 1, 2)));
    }
}
