<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 29/06/2018
 * Time: 19:11
 */

namespace Tools4Schools\SDK;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Tools4Schools\SDK\Request\Processors\Processor;


class GuzzleConnection implements ConnectionInterface
{
    protected $handlers;

    protected $config;

    /**
     * The api version to target.
     *
     * @var string
     */
    protected $apiVersion = '';

    public function __construct(array $config = [])
    {
        $this->handlers =  HandlerStack::create();


        if (isset($config['default_access_token'])) {
            //$this->setDefaultAccessToken($config['default_access_token']);
        }

        if(isset($config['middleware']))
        {
            foreach ($config['middleware'] as $middleware)
            {
                if(is_string($middleware))
                {
                    $middleware = new $middleware;
                }
                $this->addMiddleware($middleware);
            }
            unset($config['middleware']);
        }

        $this->config = $config;

    }

    public function addMiddleware(callable $middleware)
    {
        $this->handlers->push($middleware);
        return $this;
    }

    protected function createClient()
    {
        return new Client([
            'handler' => $this->handlers,
            'base_uri'=> $this->config['base_uri'].'/' . $this->config['default_api_version'] . '/',
            'headers' => [
                'User-Agent' => 'Tools4Schools PHP SDK v'.Tools4Schools::VERSION,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function setApplication($app_id,$app_secret)
    {
        $this->config['app_id'] = $app_id;
        $this->config['app_secret'] = $app_secret;
    }

    public function get(Request $request)
    {
        return $this->createClient()->send($request);
    }

    public function getPostProcessor()
    {
       return new Processor();
    }
}