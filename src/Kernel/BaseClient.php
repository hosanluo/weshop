<?php

namespace WechatShop\Kernel;

use WechatShop\Kernel\Support\Log;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use WechatShop\Kernel\Http\Response;
use WechatShop\Kernel\Traits\HasHttpRequests;
use WechatShop\Kernel\Exceptions\InvalidArgumentException;

class BaseClient
{
    use HasHttpRequests {
        request as performRequest;
    }

    protected $httpClient;

    protected $config;

    protected $accessToken;

    protected $tokenKey = 'access_token';

//    protected static $maxRetries = 2;

    public function __construct(array $config)
    {
        if (!is_array($config) || !isset($config['access_token'])) {
            throw new InvalidArgumentException('base_client init error. invalid config');
        }

        $this->config = $config;
        $this->accessToken = $config['access_token'];
    }

    /**
     * GET request.
     *
     * @param string $url
     * @param array  $query
     *
     * @return \Psr\Http\Message\ResponseInterface|\WechatShop\Kernel\Support\Collection|array|object|string
     *
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpGet(string $url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * POST request.
     *
     * @param string $url
     * @param array  $data
     *
     * @return \Psr\Http\Message\ResponseInterface|\WechatShop\Kernel\Support\Collection|array|object|string
     *
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpPost(string $url, array $data = [])
    {
        return $this->request($url, 'POST', ['form_params' => $data]);
    }

    /**
     * JSON request.
     *
     * @param string $url
     * @param array  $data
     * @param array  $query
     *
     * @return \Psr\Http\Message\ResponseInterface|\WechatShop\Kernel\Support\Collection|array|object|string
     *
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpPostJson(string $url, array $data = [], array $query = [])
    {
        return $this->request($url, 'POST', ['query' => $query, 'json' => $data]);
    }

    /**
     * Upload file.
     *
     * @param string $url
     * @param array  $files
     * @param array  $form
     * @param array  $query
     *
     * @return \Psr\Http\Message\ResponseInterface|\WechatShop\Kernel\Support\Collection|array|object|string
     *
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpUpload(string $url, array $files = [], array $form = [], array $query = [])
    {
        $multipart = [];
        $headers = [];

        if (isset($form['filename'])) {
            $headers = [
                'Content-Disposition' => 'form-data; name="media"; filename="'.$form['filename'].'"'
            ];
        }

        foreach ($files as $name => $path) {
            $multipart[] = [
                'name' => $name,
                'contents' => fopen($path, 'r'),
                'headers' => $headers
            ];
        }

        foreach ($form as $name => $contents) {
            $multipart[] = compact('name', 'contents');
        }

        return $this->request(
            $url,
            'POST',
            ['query' => $query, 'multipart' => $multipart, 'connect_timeout' => 30, 'timeout' => 30, 'read_timeout' => 30]
        );
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @param string $url
     * @param string $method
     * @param array  $options
     * @param bool   $returnRaw
     *
     * @return \Psr\Http\Message\ResponseInterface|\WechatShop\Kernel\Support\Collection|array|object|string
     *
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $url, string $method = 'GET', array $options = [], $returnRaw = false)
    {
        if (empty($this->middlewares)) {
            $this->registerHttpMiddlewares();
        }

        $response = $this->performRequest($url, $method, $options);

        return $returnRaw ? $response : $this->castResponseToType($response, $this->config['response_type'] ?? '');
    }

    /**
     * @param string $url
     * @param string $method
     * @param array  $options
     *
     * @return \WechatShop\Kernel\Http\Response
     *
     * @throws \WechatShop\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestRaw(string $url, string $method = 'GET', array $options = [])
    {
        return Response::buildFromPsrResponse($this->request($url, $method, $options, true));
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $base = [
            // http://docs.guzzlephp.org/en/stable/request-options.html
            'http' => [
                'timeout' => 30.0,
                'base_uri' => 'https://api.weixin.qq.com/',
            ],
        ];

        return array_replace_recursive($base, $this->config);
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        // retry
//        $this->pushMiddleware($this->retryMiddleware(), 'retry');
        // access token
        $this->pushMiddleware($this->accessTokenMiddleware(), 'access_token');
        // log
        $this->pushMiddleware($this->logMiddleware(), 'log');
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $requestOptions
     *
     * @return \Psr\Http\Message\RequestInterface
     *
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface
    {
        parse_str($request->getUri()->getQuery(), $query);

        $query = http_build_query(array_merge($this->getQuery(), $query));

        return $request->withUri($request->getUri()->withQuery($query));
    }

    /**
     * The request query will be used to add to the request.
     *
     * @return array
     *
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    protected function getQuery(): array
    {
        return [$this->queryName ?? $this->tokenKey => $this->accessToken];
    }

    /**
     * Attache access token to request query.
     *
     * @return \Closure
     */
    protected function accessTokenMiddleware()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if ($this->accessToken) {
                    $request = $this->applyToRequest($request, $options);
                }

                return $handler($request, $options);
            };
        };
    }

    /**
     * Log the request.
     *
     * @return \Closure
     */
    protected function logMiddleware()
    {
        return Middleware::tap(function (RequestInterface $request, $options) {
            Log::debug("Request: {$request->getMethod()} {$request->getUri()} ".json_encode($options));
            Log::debug('Request headers:'.json_encode($request->getHeaders()));
        });
    }

//    /**
//     * Return retry middleware.
//     *
//     * @return \Closure
//     */
//    protected function retryMiddleware()
//    {
//        return Middleware::retry(function (
//            $retries,
//            RequestInterface $request,
//            ResponseInterface $response = null
//        ) {
//            // Limit the number of retries to 2
//            if ($retries <= self::$maxRetries && $response && $body = $response->getBody()) {
//                // Retry on server errors
//                if (false !== stripos($body, 'errcode') && (false !== stripos($body, '40001') || false !== stripos($body, '42001'))) {
//                    $field = $this->accessToken->getQueryName();
//                    $token = $this->accessToken->getToken(true);
//
//                    $request = $request->withUri($newUri = Uri::withQueryValue($request->getUri(), $field, $token));
//
//                    Log::debug("Retry with Request Token: {$token}");
//                    Log::debug("Retry with Request Uri: {$newUri}");
//
//                    return true;
//                }
//            }
//
//            return false;
//        });
//    }
}
