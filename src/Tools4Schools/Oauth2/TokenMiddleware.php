<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 29/06/2018
 * Time: 14:39
 */

namespace Tools4Schools\SDK\Oauth2;


use function GuzzleHttp\Psr7\modify_request;
use Psr\Http\Message\RequestInterface;

class TokenMiddleware
{
    protected $config;
    public function __construct(\GuzzleHttp\Client $client,$config)
    {
        $this->config = $config;
    }

    public function __invoke(callable $next)
    {
        return function (RequestInterface $request,array $options = []) use ($next)
        {
            $request = $this->applyToken($request);
            return $next($request,$options);
        };
    }

    protected function applyToken(RequestInterface $request)
    {
        //if(!$this->hasValidToken())
        {
            $this->acquireAccessToken();
        }

        return modify_request($request,[
            'set_headers' =>[
                'Authorization' => (string) $this->getToken(),
            ]
        ]);
    }

    private function acquireAccessToken()
    {
        $parameters = $this->getTokenRequestParameters();
        $response = $this->client->request('POST', $this->config->getTokenRoute(), [
            'form_params' => $parameters,
            // We'll use the default handler so we don't rerun our middleware
            'handler' => \GuzzleHttp\choose_handler(),
        ]);
        $response = \GuzzleHttp\json_decode((string) $response->getBody(), true);
        $this->token = new AccessToken(
            $response['access_token'],
            (int) $response['expires_in'],
            $response['refresh_token']
        );
    }
    private function getTokenRequestParameters()
    {
        if ($this->getToken() and $this->getToken()->isRefreshable()) {
            return [
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->getToken()->refreshToken()
            ];
        }
        return [
            'grant_type' => 'password',
            'username' => $this->config->username(),
            'password' => $this->config->password()
        ];
    }
}