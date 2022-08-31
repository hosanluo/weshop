<?php

namespace WechatShop\Application\Register;

use WechatShop\Kernel\BaseClient;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;

class Client extends BaseClient
{

    /**
     * apply (接入申请)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function apply()
    {
        return $this->httpPostJson('shop/register/apply');
    }

    /**
     * check (获取接入状态)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function check()
    {
        return $this->httpPostJson('shop/register/check');
    }

    /**
     * finish_access_info (完成接入任务)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \WechatShop\Kernel\Exceptions\InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function finishAccessInfo(int $access_info_item)
    {
        return $this->httpPostJson('shop/register/finish_access_info', \compact('access_info_item'));
    }

    /**
     * apply_scene (场景接入申请)
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\WechatShop\Kernel\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     */
    public function applyScene(int $scene_group_id = 1)
    {
        return $this->httpPostJson('shop/register/apply_scene', \compact('scene_group_id'));
    }
}
