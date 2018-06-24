<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 23/06/2018
 * Time: 19:08
 */

namespace Tools4Schools\SDK;


use Tools4Schools\SDK\HttpClient\GuzzleClient;

class Tools4SchoolsSdk
{
    /**
     * @const string Version number of the Tools4Schools PHP SDK.
     */
    const VERSION = '0.0.1';

    /**
     * @const string Default API version for requests.
     */
    const DEFAULT_API_VERSION = 'v1';

    /**
     * @var Tools4SchoolsClient The Tools4Schools client service.
     */
    protected $client;

    /**
     * @var AccessToken|null The default access token to use with requests.
     */
    protected $defaultAccessToken;

    /**
     * @var string|null The default Api version we want to use.
     */
    protected $defaultApiVersion;

    public function __construct(array $config = [])
    {
        $config = array_merge([
            'default_api_version' => static::DEFAULT_API_VERSION,
            'enable_beta_mode' => false,
            'http_client_handler' => null
        ], $config);

        $this->client = new Tools4SchoolsClient(new GuzzleClient(),$config['enable_beta_mode']);
    }

    public function get($endpoint,$accessToken = null,$apiVersion = null)
    {
        return $this->sendRequest(
            'GET',
            $endpoint,
            $params = [],
            $accessToken,
            $apiVersion
        );
    }

    public function post($endpoint,array $params = [],$accessToken = null,$apiVersion = null)
    {
        return $this->sendRequest(
            'POST',
            $endpoint,
            $params = [],
            $accessToken,
            $apiVersion
        );
    }

    public function delete($endpoint,array $params = [],$accessToken = null,$apiVersion = null)
    {
        return $this->sendRequest(
            'DELETE',
            $endpoint,
            $params = [],
            $accessToken,
            $apiVersion
        );
    }

    public function sendRequest($method, $endpoint, array $params = [], $accessToken = null, $apiVersion = null)
    {
        $accessToken = $accessToken ?: $this->defaultAccessToken;
        $apiVersion = $apiVersion ?: $this->defaultApiVersion;
        $request = $this->request($method, $endpoint, $params, $accessToken,  $apiVersion);
        return $this->lastResponse = $this->client->sendRequest($request);
    }

    public function request($method,$endpoint,array $params =[],$accessToken = null,$apiVersion = null)
    {
        $accessToken = $accessToken ?: $this->defaultAccessToken;
        $apiVersion = $apiVersion ?: $this->defaultApiVersion;

        return new Request(
            $accessToken,
            $method,
            $endpoint,
            $params,
            $apiVersion
        );
    }

}