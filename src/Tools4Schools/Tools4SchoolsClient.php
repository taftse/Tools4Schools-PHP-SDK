<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 23/06/2018
 * Time: 20:00
 */

namespace Tools4Schools\SDK;


use Tools4Schools\SDK\HttpClient\HttpClientInterface;

class Tools4SchoolsClient
{
    /**
     * @const string Production API URL.
     */
    const BASE_API_URL = 'https://api.tools4schools.ie';

    /**
     * @const string Beta API URL.
     */
    const BASE_API_URL_BETA = 'https://staging.api.tools4schools.ie';

    /**
     * @const int The timeout in seconds for a normal request.
     */
    const DEFAULT_REQUEST_TIMEOUT = 60;

    /**
     * @var bool Toggle to use beta api url.
     */
    protected $enableBetaMode = false;

    /**
     * @var HttpClientInterface HTTP client.
     */
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient = null,$enableBeta = false)
    {
        $this->httpClient = $httpClient;
        $this->enableBetaMode = $enableBeta;
    }


    /**
     * Toggle beta mode.
     *
     * @param boolean $betaMode
     */
    public function enableBetaMode($betaMode = true)
    {
        $this->enableBetaMode = $betaMode;
    }

    /**
     * Returns the base api URL.
     *
     * @return string
     */
    public function getBaseApiUrl()
    {
        return $this->enableBetaMode ? static::BASE_API_URL_BETA : static::BASE_API_URL;
    }

    /**
     * Prepares the request for sending to the client handler.
     *
     * @param Request $request
     *
     * @return array
     */
    public function prepareRequestMessage(Request $request)
    {
        $url = $this->getBaseApiUrl().$request->getUrl();

        return [$url,
            $request->getMethod(),
            $request->getHeaders(),
           ""// $request->getBody()
            ];
    }

    public function sendRequest(Request $request)
    {

        list($url,$method,$headers,$body) = $this->prepareRequestMessage($request);

        $rawResponse = $this->httpClient->send($url,$method,$body,$headers,static::DEFAULT_REQUEST_TIMEOUT);

        $response = new Response($request,$rawResponse->getBody(),$rawResponse->getResponseCode(),$rawResponse->getHeaders());

        if($response->isError())
        {
            throw $response->getThrownException();
        }

        return $response;
    }
}