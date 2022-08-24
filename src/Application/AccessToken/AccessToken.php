<?php

namespace WechatShop\Application\AccessToken;

use EasyWeChat\Kernel\AccessToken as BaseAccessToken;

/**
 * Class AccessToken.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class AccessToken extends BaseAccessToken
{
    /**
     * @var string
     */
    protected $endpointToGetToken = '/cgi-bin/token';

    /**
     * {@inheritdoc}
     */
    protected function getCredentials(): array
    {
        return [
            'grant_type' => 'client_credential',
            'appid' => $this->app['config']['app_id'],
            'secret' => $this->app['config']['secret'],
        ];
    }
}
