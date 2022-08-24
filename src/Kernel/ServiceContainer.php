<?php
/**
 * Notes:
 * User: luoshiqiang
 * Date: 2022/8/24
 * Time: 14:24
 */

namespace WechatShop\Kernel;

/**
 * Class ServiceContainer.
 *
 * @property \Symfony\Component\HttpFoundation\Request          $request
 * @property \GuzzleHttp\Client                                 $http_client
 * @property \Monolog\Logger                                    $logger
 * @property \Symfony\Component\EventDispatcher\EventDispatcher $events
 */
class ServiceContainer extends \EasyWeChat\Kernel\ServiceContainer
{}
