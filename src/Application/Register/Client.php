<?php

namespace WechatShop\Application\Register;

use WechatShop\Kernel\BaseClient;

class Client extends BaseClient
{

    public function apply()
    {
        return $this->httpPostJson('shop/register/apply');
    }
}
