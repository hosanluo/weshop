<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:46
 */

namespace WechatShop\Application\Spu;

use WechatShop\Kernel\BaseClient;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;

class Client extends BaseClient
{
//    protected $required;

    /**
     * add (添加商品)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function add(array $params)
    {
        $this->required = ['out_product_id', 'title', 'path', 'head_img', 'third_cat_id', 'brand_id', 'skus', 'scene_group_list'];
        $this->verifyParams($params);

        foreach ($params['skus'] as $key => $sku) {
            $this->required = ['out_product_id', 'out_sku_id', 'thumb_img', 'sale_price', 'market_price', 'stock_num', 'sku_attrs'];
            $this->verifyParams($sku);
            $this->required = ['attr_key', 'attr_value'];
            foreach ($params['skus'][$key]['sku_attrs'] as $skuAttrs) {
                $this->verifyParams($skuAttrs);
            }
        }

        return $this->httpPost('shop/spu/add', $params);
    }

    /**
     * del (删除商品)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function del(array $params = [])
    {
        return $this->httpPostJson('shop/spu/del', $params);
    }

    /**
     * del_audit (撤回商品审核)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function del_audit(array $params = [])
    {
        return $this->httpPostJson('shop/spu/del_audit', $params);
    }

    /**
     * get (获取商品)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function get(array $params = [])
    {
        return $this->httpPostJson('shop/spu/get', $params);
    }

    /**
     * getList (获取商品列表)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function getList(array $params = [])
    {
        $this->required = ['status', 'page', 'page_size'];
        $this->verifyParams($params);

        return $this->httpPostJson('shop/spu/get_list', $params);
    }

    /**
     * update (更新商品)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function update(array $params = [], string $out_product_id = '', int $product_id = 0)
    {
        if (!$out_product_id && !$product_id) {
            throw new InvalidArgumentException('Attribute out_product_id, product_id can not be empty at the same time!');
        }

        $this->required = ['title', 'path', 'head_img', 'third_cat_id', 'brand_id', 'skus', 'scene_group_list'];
        $this->verifyParams($params);

        if (!is_array($params['skus'])) {
            throw new InvalidArgumentException('Attribute skus need to be an array!');
        }
        foreach ($params['skus'] as $key => $sku) {
            $this->required = ['out_product_id', 'out_sku_id', 'thumb_img', 'sale_price', 'market_price', 'stock_num', 'sku_attrs'];
            $this->verifyParams($sku);
            $this->required = ['attr_key', 'attr_value'];
            foreach ($params['skus'][$key]['sku_attrs'] as $skuAttrs) {
                $this->verifyParams($skuAttrs);
            }
        }

        $out_product_id != '' && $params = array_merge(compact('out_product_id'), $params);
        $product_id != 0 && $params = array_merge(compact('product_id'), $params);

        return $this->httpPostJson('shop/spu/update', $params);
    }

    /**
     * listing (上架商品)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function listing(array $params = [])
    {
        return $this->httpPostJson('shop/spu/listing', $params);
    }

    /**
     * delisting (下架商品)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function delisting(array $params = [])
    {
        return $this->httpPostJson('shop/spu/delisting', $params);
    }

    /**
     * updateWithoutAudit (免审更新商品字段)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function updateWithoutAudit(array $params = [], string $out_product_id = '', int $product_id = 0)
    {
        if (!$out_product_id && !$product_id) {
            throw new InvalidArgumentException('Attribute out_product_id, product_id can not be empty at the same time!');
        }

        if (isset($params['skus'])) {
            if (!isset($params['skus']['out_sku_id']) || !$params['skus']['out_sku_id']) {
                throw new InvalidArgumentException('Attribute skus.out_sku_id can not be empty!');
            }
        }

        return $this->httpPostJson('shop/spu/update_without_audit', $params);
    }

//    /**
//     * verifyParams
//     *
//     * @throws InvalidArgumentException
//     */
//    public function verifyParams(array $params)
//    {
//        foreach ($this->required as $value) {
//            if (is_array($value)) {
//                $verifyKey = $value['key'];
//                $verifyValue = $value['value'];
//                if (is_array($verifyValue) && (!isset($params[$verifyKey]) || !in_array($params[$verifyKey], $verifyValue))) {
//                    throw new InvalidArgumentException('Attribute "' . $value . '" can not be empty!');
//                }
//
//                if (!isset($params[$verifyKey]) || $params[$verifyKey] != $verifyValue) {
//                    throw new InvalidArgumentException('Attribute "' . $value . '" can not be empty!');
//                }
//            } else {
//                if (!isset($params[$value])
//                    || empty($params[$value])
//                    || is_null($params[$value])
//                    || $params[$value] === ''
//                ) {
//                    throw new InvalidArgumentException('Attribute "' . $value . '" can not be empty!');
//                }
//            }
//        }
//    }
}
