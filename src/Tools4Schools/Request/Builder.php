<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 29/06/2018
 * Time: 19:00
 */

namespace Tools4Schools\SDK\Request;

use GuzzleHttp\Psr7\Request;
use Tools4Schools\SDK\ConnectionInterface;
use Tools4Schools\SDK\Request\Processors\Processor;

class Builder
{

    /**
     * The api connection instance.
     *
     * @var \Tools4Schools\SDK\ConnectionInterface
     */
    public $connection;

    /**
     * The api request post processor instance.
     *
     * @var \Tools4Schools\SDK\Request\Processors\Processor
     */
    public $processor;

    /**
     * The endpoint for the request
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The columns that should be returned.
     *
     * @var array
     */
    public $columns;

    public function __construct(ConnectionInterface $connection,Processor $processor = null)
    {
        $this->connection = $connection;
        $this->processor = $processor ?: $connection->getPostProcessor();
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     * @return \Illuminate\Support\Collection
     */
    public function get($columns = ['*'])
    {
        return collect($this->onceWithColumns($columns, function () {
            return $this->processor->processGet($this, $this->executeGet());
        }));
    }
    /**
     * Run the query as a "select" statement against the connection.
     *
     * @return array
     */
    // runSelect
    protected function executeGet()
    {
        return $this->connection->get($this->getRequest());
    }

    /**
     * Execute the given callback while selecting the given columns.
     *
     * After running the callback, the columns are reset to the original value.
     *
     * @param  array  $columns
     * @param  callable  $callback
     * @return mixed
     */
    protected function onceWithColumns($columns, $callback)
    {
        $original = $this->columns;
        if (is_null($original)) {
            $this->columns = $columns;
        }
        $result = $callback();
        $this->columns = $original;
        return $result;
    }

    protected function getRequest()
    {
        return new Request('GET',$this->getEndpoint());
    }


    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }
}