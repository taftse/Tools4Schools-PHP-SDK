<?php


namespace Tools4Schools\SDK\Graph;



use Illuminate\Support\Str;
use Tools4Schools\SDK\ConnectionInterface;
use Tools4Schools\SDK\Graph\Concerns\HasAttributes;
use Tools4Schools\SDK\Request\Builder as RequestBuilder;
use Tools4Schools\SDK\Graph\Builder as GraphRequestBuilder;
use Tools4Schools\SDK\Request\Processors\Processor;

class Model
{
    use HasAttributes;
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
        $builder = new GraphRequestBuilder(new RequestBuilder($this->getConnection(),new Processor()));

        return $builder->setModel($this);

    }

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
     * Set the connection associated with the model.
     *
     * @param \Tools4Schools\SDK\ConnectionInterface $connection
     * @return void
     */

    public static function setConnection(ConnectionInterface $connection)
    {
        static::$connection = $connection;
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
     * Create a new instance of the given model.
     *
     * @param  array  $attributes
     * @param  bool  $exists
     * @return static
     */
    public function newInstance($attributes = [], $exists = false)
    {
        // This method just provides a convenient way for us to generate fresh model
        // instances of this current model. It is particularly useful during the
        // hydration of new objects via the Eloquent query builder instances.
        $model = new static((array) $attributes);
        //$model->exists = $exists;
        $model->setConnection(
            $this->getConnection()
        );
        return $model;
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
     * Create a new model instance that is existing.
     *
     * @param  array  $attributes
     * @param  string|null  $connection
     * @return static
     */
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $model = $this->newInstance([], true);
        $model->setRawAttributes((array) $attributes, true);
        $model->setConnection($connection ?: $this->getConnection());
        //$model->fireModelEvent('retrieved', false);
        return $model;
    }

    /**
     * Save the model to the api.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        // If the model already exists on the graph then we can just update the record
        // that is already in the graph using the current IDs in this "where"
        // clause to only update this model. Otherwise, we'll just insert them.
        if ($this->exists) {

            // if model has been edited
            if($this->isDirty()){
                // send a put or patch request
                $saved =  $this->preformUpdate($query);
            }
            $saved =  true;

        }
        // If the model is brand new, we'll insert it into our database and set the
        // ID attribute on the model to the value of the newly inserted row's ID
        // which is typically an auto-increment value managed by the database.
        else{
            // send a post request
            $saved = $this->preformInsert($query);

        }

        if($saved)
        {
            // finish saved
        }

        return $saved;
    }
}