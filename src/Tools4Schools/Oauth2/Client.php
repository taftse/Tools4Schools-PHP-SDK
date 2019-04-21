<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/06/2018
 * Time: 14:32
 */

namespace Tools4Schools\SDK\Oauth2;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client implements CredentialFetcherInterface
{
    protected $client;

    protected $tokenUrl = 'https://login.tools4schools.ie/oauth/token';

    protected $config;

    protected $grantType = 'authorization_code';

    /**
     * @var AccessToken
     */
    protected $token;

    public function __construct(array $config = [])
    {
        $this->config = $config;

        $this->client = new GuzzleClient();

        if(isset($config['token_url']))
        {
            $this->tokenUrl = $config['token_url'];
        }

        if(isset($config['grant_type']))
        {
            $this->grantType = $config['grant_type'];
        }

        if(isset($config['access_token']))
        {
            $this->token = new AccessToken(['access_token' =>$config['access_token'] ]);
        }
    }

    /**
     * Fetches the auth tokens based on the current state.
     *
     * @return array the response
     */
    public function fetchAuthToken(callable $httpHandler = null)
    {
        if(isset($this->token))
        {
            return $this->token->getToken();
        }
        $response = $this->client->send($this->generateCredentialRequest());
        $credentials = $this->parseResponse($response);
        $this->updateToken($credentials);

        return$credentials;
    }

    /**
     * Generates a request for token credentials.
     *
     * @return RequestInterface the authorization Url.
     */
    public function generateCredentialRequest()
    {

        $grantType = $this->getGrantType();
        $params = array('grant_type' => $grantType);
        switch ($grantType){
            case 'authorization_code':
                //$params['code'] = $this->config['code'];
                $params['redirect_uri'] = $this->config['redirect_url'];
                $this->addClientCredentials($params);
                break;
            case 'password':
                $params['username'] = $this->config['username'];
                $params['password'] = $this->config['password'];
                $this->addClientCredentials($params);
                break;
            case 'refresh_token':
                $params['refresh_token'] = $this->config['refresh_token']();
                $this->addClientCredentials($params);
                break;
            default:
                throw new \DomainException('Unsupported Grant type');
                break;
        };

        $headers = [
            'Cache-Control' => 'no-store',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        return new Request(
            'POST',
            $this->getTokenUrl(),
            $headers,
            Psr7\build_query($params)
        );

    }

    /**
     * Get the token URL for the provider.
     *
     * @return string
     */
    protected function getTokenUrl(){
        return $this->tokenUrl;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    private function addClientCredentials(&$params)
    {
        $clientId = $this->config['client_id'];
        $clientSecret = $this->config['client_secret'];
        if ($clientId && $clientSecret) {
            $params['client_id'] = $clientId;
            $params['client_secret'] = $clientSecret;
        }
        return $params;
    }

    /**
     * Gets the current grant type.
     *
     * @return string
     */
    public function getGrantType()
    {

        if (!is_null($this->grantType)) {
            return $this->grantType;
        }
        // Returns the inferred grant type, based on the current object instance
        // state.
        if (isset($this->config['code']) && !is_null($this->config['code'])) {
            return 'authorization_code';
        }
        if (isset($this->config['refresh_token']) && !is_null($this->config['refresh_token'])) {
            return 'refresh_token';
        }
        if (isset($this->config['username']) && !is_null($this->config['username']) && isset($this->config['password']) && !is_null($this->config['password'])) {
            return 'password';
        }

        return null;
    }

    /**
     * Parses the fetched tokens.
     *
     * @param ResponseInterface $resp the response.
     *
     * @return array the tokens parsed from the response body.
     *
     * @throws \Exception
     */
    public function parseResponse(ResponseInterface $resp)
    {
        $body = (string)$resp->getBody();
        if ($resp->hasHeader('Content-Type') &&
            $resp->getHeaderLine('Content-Type') == 'application/x-www-form-urlencoded'
        ) {
            $res = array();
            parse_str($body, $res);
            return $res;
        }
        // Assume it's JSON; if it's not throw an exception
        if (null === $res = json_decode($body, true)) {
            throw new \Exception('Invalid JSON response');
        }
        return $res;
    }

}