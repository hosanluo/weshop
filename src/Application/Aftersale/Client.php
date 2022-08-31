<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:46
 */

namespace WechatShop\Application\Aftersale;

use WechatShop\Kernel\BaseClient;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;

class Client extends BaseClient
{

    /**
     * add (创建售后)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function add(array $params = [])
    {
        $this->required = ['out_order_id', 'out_aftersale_id', 'path', 'refund', 'openid', 'type', 'create_time', 'status', 'finish_all_aftersale', 'product_infos'];
        $this->verifyParams($params);

        if (!is_array($params['product_infos'])) {
            throw new InvalidArgumentException('Attribute "product_infos" need to be an array!');
        }
        foreach ($params['product_infos'] as $productInfo) {
            if (!is_array($productInfo)) {
                throw new InvalidArgumentException('Attribute "product_infos.[]value" need to be an array!');
            }

            $this->required = ['out_product_id', 'out_sku_id', 'product_cnt'];
            $this->verifyParams($productInfo);
        }

        return $this->httpPostJson('shop/aftersale/add', $params);
    }

    /**
     * get (获取售后)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function get(string $openid, string $out_order_id = '')
    {
        return $this->httpPostJson('shop/aftersale/get', compact('openid', 'out_order_id'));
    }

    /**
     * update (更新售后)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function update(array $params = [])
    {
        $this->required = ['out_order_id', 'out_aftersale_id', 'openid', 'status', 'finish_all_aftersale'];
        $this->verifyParams($params);

        return $this->httpPostJson('shop/aftersale/update', $params);
    }
}
