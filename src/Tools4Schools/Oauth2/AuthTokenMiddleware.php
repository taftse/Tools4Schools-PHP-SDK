<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/06/2018
 * Time: 14:10
 */

namespace Tools4Schools\SDK\Oauth2;


use Psr\Http\Message\RequestInterface;

class AuthTokenMiddleware
{
    protected $fetcher;

    public function __construct(CredentialFetcherInterface $fetcher = null)
    {
        $this->fetcher = $fetcher?: new Client();
    }

    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request,array $options) use ($handler){

            $request = $request->withHeader('authorization', 'Bearer ' . $this->fetchToken());
            return $handler($request,$options);
        };
    }

    private function fetchToken()
    {
       $auth_token =  $this->fetcher->fetchAuthToken();

       return $auth_token;
    }
}