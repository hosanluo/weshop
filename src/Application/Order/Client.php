<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:46
 */

namespace WechatShop\Application\Order;

use WechatShop\Kernel\BaseClient;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;

class Client extends BaseClient
{

    /**
     * check (检查场景值是否在支付校验范围内(待废弃))
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function check(int $scene)
    {
        if (!$scene) {
            throw new InvalidArgumentException('Attribute "scene" can not be empty!');
        }

        return $this->httpPostJson('shop/scene/check', compact('scene'));
    }

    /**
     * add (生成订单并获取ticket)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function add(array $params)
    {
        $this->verifyAddParams($params);

        return $this->httpPostJson('shop/order/add', $params);
    }

    /**
     * pay (同步支付结果)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function pay(array $params = [])
    {
        $this->required = ['openid', 'action_type'];
        $this->verifyParams($params);

        return $this->httpPostJson('shop/order/pay', $params);
    }

    /**
     * get (获取订单详情)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function get(array $params = [])
    {
        $this->required = ['openid'];
        $this->verifyParams($params);

        return $this->httpPostJson('shop/order/get', $params);
    }

    /**
     * getListByFinder (按照推广员获取订单)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function getListByFinder(array $params = [])
    {
        $this->required = ['page', 'page_size'];
        $this->verifyParams($params);

        return $this->httpPostJson('shop/order/get_list_by_finder', $params);
    }

    /**
     * getListBySharer (按照分享员获取订单)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function getListBySharer(array $params = [])
    {
        $this->required = ['sharer_openid', 'page', 'page_size'];
        $this->verifyParams($params);

        return $this->httpPostJson('shop/order/get_list_by_sharer', $params);
    }

    /**
     * getList (获取订单列表)
     *
     * array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function getList(array $params = [])
    {
        $this->required = ['sort_order', 'page', 'page_size'];
        $this->verifyParams($params);

        return $this->httpPostJson('shop/order/get_list', $params);
    }

    public function verifyAddParams(array $params = [])
    {
        $this->required = ['create_time', 'out_order_id', 'openid', 'path', 'scene', 'order_detail', 'delivery_detail', 'address_info'];
        $this->verifyParams($params);

        $this->required = ['product_infos', 'pay_info', 'price_info'];
        if (!is_array($params['order_detail'])) {
            throw new InvalidArgumentException('Attribute "order_detail" need to be an array');
        }
        $this->verifyParams($params['order_detail']);

        $this->required = ['out_product_id', 'out_sku_id', 'product_cnt', 'sale_price', 'real_price', 'head_img', 'title', 'path'];
        if (!is_array($params['order_detail']['product_infos'])) {
            throw new InvalidArgumentException('Attribute "order_detail.product_infos" need to be an array');
        }
        foreach ($params['order_detail']['product_infos'] as $productInfo) {
            if (!is_array($productInfo)) {
                throw new InvalidArgumentException('Attribute "order_detail.product_infos.[]value" need to be an array');
            }
            $this->verifyParams($productInfo);
        }

        $this->required = [['key' => 'pay_method_type', 'value' => [0, 1, 2]]];
        if (!is_array($params['order_detail']['pay_info'])) {
            throw new InvalidArgumentException('Attribute "order_detail.pay_info" need to be an array');
        }
        $this->verifyParams($params['order_detail']['pay_info']);

        $this->required = ['order_price', 'freight'];
        if (!is_array($params['order_detail']['price_info'])) {
            throw new InvalidArgumentException('Attribute "order_detail.price_info" need to be an array');
        }
        $this->verifyParams($params['order_detail']['price_info']);

        $this->required = [['key' => 'delivery_type', 'value' => [1, 2, 3, 4]]];
        if (!is_array($params['delivery_detail'])) {
            throw new InvalidArgumentException('Attribute "delivery_detail" need to be an array');
        }
        $this->verifyParams($params['delivery_detail']);

        $this->required = ['receiver_name', 'detailed_address', 'tel_number'];
        if (!is_array($params['address_info'])) {
            throw new InvalidArgumentException('Attribute "address_info" need to be an array');
        }
        $this->verifyParams($params['address_info']);
    }


}
