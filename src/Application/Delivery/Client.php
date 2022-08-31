<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:46
 */

namespace WechatShop\Application\Delivery;

use WechatShop\Kernel\BaseClient;

class Client extends BaseClient
{

    /**
     * getCompanyList (获取快递公司列表)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function getCompanyList()
    {
        return $this->httpPostJson('shop/delivery/get_company_list');
    }

    /**
     * send (订单发货)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidArgumentException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function send(array $params = [])
    {
        $this->verifySendParams($params);

        return $this->httpPostJson('shop/delivery/send', $params);
    }

    /**
     * recieve (订单确认收货)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidArgumentException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function recieve(array $params = [])
    {
        $this->required = ['openid'];
        $this->verifyParams($params);

        return $this->httpPostJson('shop/delivery/recieve', $params);
    }

    /**
     * verifySendParams (校验订单发货提交数据)
     *
     * void
     *
     * @throws \WechatShop\Kernel\Exceptions\InvalidArgumentException
     */
    public function verifySendParams(array $params = [])
    {
        $this->required = ['openid', 'finish_all_delivery'];
        $this->verifyParams($params);

        if (isset($params['delivery_type']) && $params['delivery_type'] == 1) {
            $this->required = ['delivery_list'];
            $this->verifyParams($params);

            if (!is_array($params['delivery_list'])) {
                throw new \WechatShop\Kernel\Exceptions\InvalidArgumentException('Attribute "delivery_type" need to be an array!');
            }

            foreach ($params['delivery_list'] as $value) {
                if (!is_array($value)) {
                    throw new \WechatShop\Kernel\Exceptions\InvalidArgumentException('Attribute "delivery_type.[]value" need to be an array!');
                }
                $this->required = ['delivery_id', 'waybill_id', 'product_info_list'];
                $this->verifyParams($value);

                if (!is_array($value['product_info_list'])) {
                    throw new \WechatShop\Kernel\Exceptions\InvalidArgumentException('Attribute "product_info_list" need to be an array!');
                }
                foreach ($value['product_info_list'] as $productInfoList) {
                    if (!is_array($productInfoList)) {
                        throw new \WechatShop\Kernel\Exceptions\InvalidArgumentException('Attribute "product_info_list.[]value" need to be an array!');
                    }

                    $this->required = ['out_product_id', 'out_sku_id'];
                    $this->verifyParams($productInfoList);
                }
            }
        }
    }
}
