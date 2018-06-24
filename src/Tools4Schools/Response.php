<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 23/06/2018
 * Time: 20:20
 */

namespace Tools4Schools\SDK;


class Response
{
    /**
     * @var int The HTTP status code response from API.
     */
    protected $httpStatusCode;
    /**
     * @var array The headers returned from API.
     */
    protected $headers;
    /**
     * @var string The raw body of the response from API.
     */
    protected $body;
    /**
     * @var array The decoded body of the API response.
     */
    protected $decodedBody = [];
    /**
     * @var Request The original request that returned this response.
     */
    protected $request;
    /**
     * @var SDKException The exception thrown by this request.
     */
    protected $thrownException;
    /**
     * Creates a new Response entity.
     *
     * @param Request $request
     * @param string|null     $body
     * @param int|null        $httpStatusCode
     * @param array|null      $headers
     */
    public function __construct(Request $request, $body = null, $httpStatusCode = null, array $headers = [])
    {
        $this->request = $request;
        $this->body = $body;
        $this->httpStatusCode = $httpStatusCode;
        $this->headers = $headers;

    }

    /**
     * Return the access token that was used for this response.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->request->getAccessToken();
    }

}