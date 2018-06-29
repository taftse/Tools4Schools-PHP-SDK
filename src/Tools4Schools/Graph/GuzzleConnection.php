<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 24/06/2018
 * Time: 18:46
 */

namespace Tools4Schools\SDK\Graph;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Mockery\Exception;
use Tools4Schools\SDK\Oauth2\TokenMiddleware;

class GuzzleConnection implements ConnectionInterface
{

    /**
     * The active guzzle Client connection.
     *
     * @var \Client|\Closure
     */
    protected $client;

    /**
     * The base_url for the api.
     *
     * @var string
     */
    protected $base_url;

    /**
     * The api version to target.
     *
     * @var string
     */
    protected $apiVersion = '';

    /**
     * The guzzle client configuration options.
     *
     * @var array
     */
    protected $config = [];


    /**
     * Create a new api connection instance.
     *
     * @param  string $base_url
     * @param  string $apiVersion
     * @param  array $config
     * @return void
     */
    public function __construct($base_url = '', $apiVersion = '', array $config = [])
    {


        // First we will setup the default properties. We keep track of the DB
        // name we are connected to since it is needed when some reflective
        // type commands are run such as checking whether a table exists.
        $this->base_url = $base_url;

        $this->apiVersion = $apiVersion;

        $this->config = $config;

        // We need to initialize a query grammar and the query post processors
        // which are both very important parts of the database abstractions
        // so we initialize these to their default values while starting.
        // $this->useDefaultQueryGrammar();

        //$this->useDefaultPostProcessor();


    }


    public function send(Request $request)
    {
        return $this->getClient()->send($request);
    }

    protected function getClient()
    {
        $stack = HandlerStack::create();

        if(isset($this->config['middleware'])) {
            foreach ($this->config['middleware'] as $middleware) {
                $stack->push($middleware);
            }
        }
        $client = new Client([
            'base_uri' => $this->base_url . '/' . $this->apiVersion . '/',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'handler' => $stack,
        ]);

       // $stack->push(new TokenMiddleware($client, $this->config));
        return $client;
    }
}

