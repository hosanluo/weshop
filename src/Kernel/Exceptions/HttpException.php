<?php

namespace WechatShop\Kernel\Exceptions;

use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpException.
 *
 * @author overtrue <i@overtrue.me>
 */
class HttpException extends \Exception
{
    /**
     * @var \Psr\Http\Message\ResponseInterface|null
     */
    public $response;

    /**
     * @var \Psr\Http\Message\ResponseInterface|\WechatShop\Kernel\Support\Collection|array|object|string|null
     */
    public $formattedResponse;

    /**
     * HttpException constructor.
     *
     * @param string   $message
     * @param null     $formattedResponse
     * @param int|null $code
     */
    public function __construct($message, ResponseInterface $response = null, $formattedResponse = null, $code = null)
    {
        parent::__construct($message, $code);

        $this->response = $response;
        $this->formattedResponse = $formattedResponse;

        if ($response) {
            $response->getBody()->rewind();
        }
    }
}
