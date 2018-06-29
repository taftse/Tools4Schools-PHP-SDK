<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 24/06/2018
 * Time: 16:41
 */

namespace Tools4Schools\SDK\Graph;


use Illuminate\Support\Str;
use Tools4Schools\SDK\Graph\Concerns\HasAttributes;
use Tools4Schools\SDK\Graph\Concerns\HasRelationships;
use Tools4Schools\SDK\ConnectionInterface;

use Tools4Schools\SDK\Graph\Request\Builder as GraphRequestBuilder;
use Tools4Schools\SDK\Request\Builder as GuzzleRequestBuilder;

class Model
{

    use HasAttributes;
    use HasRelationships;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected static $connection;

    /**
     * The endpoint associated with the model.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';


    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {

    }



    /**
     * Get all of the models from the database.
     *
     * @param  array|mixed  $columns
     * @return \Tools4Schools\SDK\Models\Collection|static[]
     */
    public static function all($columns = ['*'])
    {
        return (new static)->newRequest()->get(
            is_array($columns) ? $columns : func_get_args()
        );
    }



    /**
     * Get the endpoint associated with the model.
     *
     * @return string
     */
    public function getEndpoint()
    {
        if (! isset($this->endpoint)) {
            return str_replace('\\', '', Str::snake(Str::plural(class_basename($this))));
        }

        return $this->endpoint;
    }

    /**
     * Set the endpoint associated with the model.
     *
     * @param  string  $endpoint
     * @return $this
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get a new request builder for the model's table.
     *
     * @return \Tools4Schools\SDK\Graph\Builder
     */
    public function newRequest()
    {
        $builder = new GraphRequestBuilder(new GuzzleRequestBuilder($this->getConnection()));
        // $builder = new RequestBuilder($this->getConnection());
        //$this->newGraphBuilder($this->newBaseRequestBuilder());
        // Once we have the graphRequest builders, we will set the model instances so the
        // builder can easily access any information it may need from the model
        // while it is constructing and executing various queries against it.
        return $builder->setModel($this);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Tools4Schools\SDK\Graph\Collection
     */
    public function newCollection(array $models = [])
    {
        return new Collection($models);
    }

    /**
     * Create a new instance of the given model.
     *
     * @param  array  $attributes
     * @param  bool  $exists
     * @return static
     */
    public function newInstance($attributes = [])
    {
        // This method just provides a convenient way for us to generate fresh model
        // instances of this current model. It is particularly useful during the
        // hydration of new objects via the Eloquent query builder instances.
        $model = new static((array)$attributes);

        return $model;
    }

    /**
     * Create a new model instance that is existing.
     *
     * @param  array  $attributes
     * @param  string|null  $connection
     * @return static
     */
    public function newFromBuilder($attributes = [])
    {
        $model = $this->newInstance([]);
        $model->setRawAttributes((array) $attributes, true);
        //$model->setConnection($connection ?: $this->getConnectionName());
        //$model->fireModelEvent('retrieved', false);
        return $model;
    }

        /**
     * Create a new Graph request builder for the model.
     *
     * @param  \Tools4Schools\SDK\Request\Builder  $query
     * @return \Tools4Schools\SDK\Graph\Builder|static
     */
 /*  public function newGraphBuilder($query)
    {
        return new Builder($query);
    }*/

    /**
     * Get a new request builder instance for the connection.
     *
     * @return \Tools4Schools\SDK\Request\Builder
     */
  /*  protected function newBaseRequestBuilder()
    {
        $connection = $this->getConnection();

        return new RequestBuilder($connection);

        /*$connection = $this->getConnection();

        return new QueryBuilder(
            $connection, $connection->getQueryGrammar(), $connection->getPostProcessor()
        );*/
    //}

    /**
     * Get the api connection for the model.
     *
     * @return \Tools4Schools\SDK\Graph\ConnectionInterface
     */
    public function getConnection()
    {
        return static::$connection;
    }

    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    /*public function getConnectionName()
    {
        return $this->connection;
    }*/

    public static function setConnection(ConnectionInterface $connection)
    {
        static::$connection = $connection;
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Determine if an attribute or relation exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return ! is_null($this->getAttribute($key));
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->attributes[$key], $this->relations[$key]);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        /*if (in_array($method, ['increment', 'decrement'])) {
            return $this->$method(...$parameters);
        }*/

        return $this->newRequest()->$method(...$parameters);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }
}