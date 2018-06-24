<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 23/06/2018
 * Time: 20:19
 */

namespace Tools4Schools\SDK;


use Tools4Schools\SDK\Authentication\AccessToken;

class Request
{
    /**
     * @var string|null The access token to use for this request.
     */
    protected $accessToken;
    /**
     * @var string The HTTP method for this request.
     */
    protected $method;
    /**
     * @var string The Api endpoint for this request.
     */
    protected $endpoint;
    /**
     * @var array The headers to send with this request.
     */
    protected $headers = [];
    /**
     * @var array The parameters to send with this request.
     */
    protected $params = [];

    /**
     * @var string Api version to use for this request.
     */
    protected $apiVersion;

    /**
     * Creates a new Request entity.
     *
     * @param AccessToken|string|null $accessToken
     * @param string|null             $method
     * @param string|null             $endpoint
     * @param array|null              $params
     * @param string|null             $eTag
     * @param string|null             $graphVersion
     */
    public function __construct( $accessToken = null, $method = null, $endpoint = null, array $params = [], $apiVersion = null)
    {
        $this->setAccessToken($accessToken);
        $this->setMethod($method);
        $this->setEndpoint($endpoint);
        $this->setParams($params);
        $this->apiVersion = $apiVersion ?: Tools4SchoolsSdk::DEFAULT_API_VERSION;
    }

    /**
     * Set the access token for this request.
     *
     * @param AccessToken|string|null
     *
     * @return Request
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        if ($accessToken instanceof AccessToken) {
            $this->accessToken = $accessToken->getValue();
        }
        return $this;
    }

    /**
     * Return the access token for this request.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }
    /**
     * Return the access token for this request as an AccessToken entity.
     *
     * @return AccessToken|null
     */
    public function getAccessTokenEntity()
    {
        return $this->accessToken ? new AccessToken($this->accessToken) : null;
    }

    /**
     * Set the HTTP method for this request.
     *
     * @param string
     */
    public function setMethod($method)
    {
        $this->method = strtoupper($method);
    }
    /**
     * Return the HTTP method for this request.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the endpoint for this request.
     *
     * @param string
     *
     * @return FacebookRequest
     *
     * @throws FacebookSDKException
     */
    public function setEndpoint($endpoint)
    {
        // Harvest the access token from the endpoint to keep things in sync
        $params = [];//FacebookUrlManipulator::getParamsAsArray($endpoint);
        if (isset($params['access_token'])) {
           // $this->setAccessTokenFromParams($params['access_token']);
        }
        // Clean the token & app secret proof from the endpoint.
        $filterParams = ['access_token', 'appsecret_proof'];
        $this->endpoint = $endpoint;//FacebookUrlManipulator::removeParamsFromUrl($endpoint, $filterParams);
        return $this;
    }
    /**
     * Return the endpoint for this request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        // For batch requests, this will be empty
        return $this->endpoint;
    }
    /**
     * Generate and return the headers for this request.
     *
     * @return array
     */
    public function getHeaders()
    {
        $headers = static::getDefaultHeaders();

        $headers['Authorization'] = 'Bearer '.$this->getAccessToken();

        return array_merge($this->headers, $headers);
    }
    /**
     * Set the headers for this request.
     *
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * Set the params for this request.
     *
     * @param array $params
     *
     * @return Request
     *
     * @throws
     */
    public function setParams(array $params = [])
    {
        if (isset($params['access_token'])) {
            $this->setAccessTokenFromParams($params['access_token']);
        }
        // Don't let these buggers slip in.
        unset($params['access_token']);
        // @TODO Refactor code above with this

        $this->dangerouslySetParams($params);
        return $this;
    }

    /**
     * Set the params for this request without filtering them first.
     *
     * @param array $params
     *
     * @return Request
     */
    public function dangerouslySetParams(array $params = [])
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }


    /**
     * Generate and return the params for this request.
     *
     * @return array
     */
    public function getParams()
    {
        $params = $this->params;
        $accessToken = $this->getAccessToken();
        if ($accessToken) {
            $params['access_token'] = $accessToken;
        }
        return $params;
    }

    /**
     * Generate and return the URL for this request.
     *
     * @return string
     */
    public function getUrl()
    {
       // $this->validateMethod();
        //$graphVersion = FacebookUrlManipulator::forceSlashPrefix($this->graphVersion);
        $apiVersion = $this->apiVersion;
        //$endpoint = FacebookUrlManipulator::forceSlashPrefix($this->getEndpoint());
        $endpoint = $this->getEndpoint();
        $url = '/'.$apiVersion. $endpoint;
        /*if ($this->getMethod() !== 'POST') {
            $params = $this->getParams();
            $url = FacebookUrlManipulator::appendParamsToUrl($url, $params);
        }*/
        return $url;
    }
    /**
     * Return the default headers that every request should use.
     *
     * @return array
     */
    public static function getDefaultHeaders()
    {
        return [
            'User-Agent' => 't4s-php-' . Tools4SchoolsSdk::VERSION,
            'Accept-Encoding' => '*',
        ];
    }
}