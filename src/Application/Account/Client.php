<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:46
 */

namespace WechatShop\Application\Account;


use WechatShop\Kernel\BaseClient;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;

class Client extends BaseClient
{

    /**
     * get_category_list (获取商家类目列表)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function getCategoryList()
    {
        return $this->httpPostJson('shop/account/get_category_list');
    }

    /**
     * get_brand_list (获取商家品牌列表)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function getBrandList()
    {
        return $this->httpPostJson('shop/account/get_brand_list');
    }

    /**
     * update_info (更新商家信息)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function updateInfo(array $params = [])
    {
        $this->required = ['service_agent_type', 'default_receiving_address'];
        $this->verifyParams($params);

        $this->required = ['receiver_name', 'detailed_address', 'tel_number', 'province', 'city', 'town'];
        if (!is_array($params['default_receiving_address'])) {
            throw new InvalidArgumentException('Attribute "default_receiving_address need to be an array!');
        }
        $this->verifyParams($params['default_receiving_address']);

        return $this->httpPostJson('shop/account/update_info', $params);
    }

    /**
     * getInfo (获取商家信息)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function getInfo()
    {
        return $this->httpPostJson('shop/account/get_info');
    }
}
