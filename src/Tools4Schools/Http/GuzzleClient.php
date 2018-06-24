<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 23/06/2018
 * Time: 20:10
 */

namespace Tools4Schools\SDK\HttpClient;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GuzzleClient implements HttpClientInterface
{
    protected $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }


    /**
     * @inheritdoc
     */
    public function send($url, $method, $body, array $headers, $timeOut)
    {
        $options = [
            'headers' => $headers,
            'body' => $body,
            'timeout' => $timeOut,
            'connect_timeout' => 10,
            //'verify' => __DIR__ . '/certs/DigiCertHighAssuranceEVRootCA.pem',
        ];
        $request = $this->client->request($method, $url, $options);
        try {
            $rawResponse = $this->client->send($request);
        } catch (RequestException $e) {
            $rawResponse = $e->getResponse();

        }
      // $rawHeaders = $this->getHeadersAsString($rawResponse);
        $rawBody = $rawResponse->getBody();
        $httpStatusCode = $rawResponse->getStatusCode();
       // return new GraphRawResponse($rawHeaders, $rawBody, $httpStatusCode);
    }

}