<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 24/06/2018
 * Time: 17:59
 */

namespace Tools4Schools\SDK\Request;

use GuzzleHttp\Psr7\Request as GuzzleRequest;

use Tools4Schools\SDK\Graph\ConnectionInterface;

class Builder
{
    /**
     * @var string|null The access token to use for this request.
     */
    protected $accessToken;

    /**
     * The endpoint which the request is targeting.
     *
     * @var string
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
     * The columns that should be returned.
     *
     * @var array
     */
    public $columns;


    /**
     * Create a new request builder instance.
     *
     * @param  \Tools4Schools\SDK\Graph\ConnectionInterface  $connection
     * @return void
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Set the endpoint which the request is targeting.
     *
     * @param  string  $endpoint
     * @return $this
     */
    public function endpoint($endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * Execute the request as a get request.
     *
     * @param  array  $columns
     * @return \Illuminate\Support\Collection
     */
    public function get($columns = ['*'])
    {

        $original = $this->columns;

        if (is_null($original)) {
            $this->columns = $columns;
        }

        //$results = $this->processor->processGet($this, $this->runSelect());
        $results = $this->send();
        $this->columns = $original;

        return collect($results);
    }

    /**
     * send the request as a get request against the connection.
     *
     * @return array
     */
    protected function send()
    {
        return $this->connection->send($this->getRequest('GET')
           // $this->toSql(), $this->getBindings(), ! $this->useWritePdo
        );
    }

    protected function getRequest($method)
    {
        return new GuzzleRequest($method,$this->endpoint);
    }


}