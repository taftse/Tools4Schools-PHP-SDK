<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 23/06/2018
 * Time: 20:06
 */

namespace Tools4Schools\SDK\HttpClient;


interface HttpClientInterface
{
    /**
     * Sends a request to the server and returns the raw response.
     *
     * @param string $url     The endpoint to send the request to.
     * @param string $method  The request method.
     * @param string $body    The body of the request.
     * @param array  $headers The request headers.
     * @param int    $timeOut The timeout in seconds for the request.
     *
     * @return  Raw response from the server.
     *
     * @throws
     */
    public function send($url, $method, $body, array $headers, $timeOut);
}