<?php

namespace WechatShop\Application\Register;

use EasyWeChat\Kernel\Contracts\AccessTokenInterface;
use EasyWeChat\Kernel\ServiceContainer;
use WechatShop\Kernel\BaseClient;

class Client extends BaseClient
{
    public function __construct(ServiceContainer $app, AccessTokenInterface $accessToken = null)
    {
        parent::__construct($app, $accessToken);
    }

    public function apply()
    {
        return $this->httpPostJson('shop/register/apply');
    }
}
