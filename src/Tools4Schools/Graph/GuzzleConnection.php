<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 24/06/2018
 * Time: 18:46
 */

namespace Tools4Schools\SDK\Graph;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

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
     * @param  string   $base_url
     * @param  string   $apiVersion
     * @param  array    $config
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




    /**
     * Run a get request against the api
     *
     * @param  string  $query
     * @param  array  $bindings
     * @param  bool  $useReadApi
     * @return array
     */
   /* public function get($request, $bindings = [], $useReadApi = true)
    {
       return $this->run($request);

        return $this->run($request, $bindings, function ($request, $bindings) use ($useReadPdo) {
            if ($this->pretending()) {
                return [];
            }

            // For select statements, we'll simply execute the query and return an array
            // of the database result set. Each element in the array will be a single
            // row from the database table, and will either be an array or objects.
            $statement = $this->prepared($this->getPdoForSelect($useReadPdo)
                ->prepare($query));

            $this->bindValues($statement, $this->prepareBindings($bindings));

            $statement->execute();

            return $statement->fetchAll();
        });
    }

    /**
     * Run a SQL statement and log its execution context.
     *
     * @param  string    $query
     * @param  array     $bindings
     * @param  \Closure  $callback
     * @return mixed
     *
     * @throws \Illuminate\Database\QueryException
     */
   /* protected function run($query, $bindings, Closure $callback)
    {
        $this->reconnectIfMissingConnection();

        $start = microtime(true);

        // Here we will run this query. If an exception occurs we'll determine if it was
        // caused by a connection that has been lost. If that is the cause, we'll try
        // to re-establish connection and re-run the query with a fresh connection.
        try {
            $result = $this->runQueryCallback($query, $bindings, $callback);
        } catch (QueryException $e) {
            $result = $this->handleQueryException(
                $e, $query, $bindings, $callback
            );
        }

        // Once we have run the query we will calculate the time that it took to run and
        // then log the query, bindings, and execution time so we will report them on
        // the event that the developer needs them. We'll log time in milliseconds.
        $this->logQuery(
            $query, $bindings, $this->getElapsedTime($start)
        );

        return $result;
    }*/



    public function send(Request $request)
    {
        $this->client = new Client([
            'base_uri' => $this->base_url.'/'.$this->apiVersion.'/'
        ]);

        return $this->client->send($request);
    }
}