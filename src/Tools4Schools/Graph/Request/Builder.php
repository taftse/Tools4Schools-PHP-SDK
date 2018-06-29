<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 29/06/2018
 * Time: 15:20
 */

namespace Tools4Schools\SDK\Graph\Request;

use Tools4Schools\SDK\Graph\Model;
use Tools4Schools\SDK\Request\Builder as RequestBuilder;

class Builder
{
    /**
     * The base request builder instance.
     *
     * @var Tools4Schools\SDK\Request\Builde
     */
    protected $request;

    /**
     * The model being queried.
     *
     * @var \Tools4Schools\SDK\Models
     */
    protected $model;

    /**
     * Create a new Eloquent query builder instance.
     *
     * @param  \Tools4Schools\SDK\Request\Builder  $query
     * @return void
     */
    public function __construct(RequestBuilder $request)
    {
        $this->request = $request;
    }

    /**
     * Set a model instance for the model being queried.
     *
     * @param  \Tools4Schools\SDK\Graph\Model  $model
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        $this->request->endpoint($model->getEndpoint());

        return $this;
    }


    /**
     * Create a collection of models from plain arrays.
     *
     * @param  array  $items
     * @return \Tools4Schools\SDK\Graph\Collection
     */
    public function hydrate(array $items)
    {
        $instance = $this->newModelInstance();
        return $instance->newCollection(array_map(function ($item) use ($instance) {
            return $instance->newFromBuilder($item);
        }, $items));
    }

    /**
     * Get the hydrated models without eager loading.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model[]
     */
    public function getModels($columns = ['*'])
    {
        return $this->hydrate(
            $this->request->get($columns)->all()
        )->all();
    }


    /**
     * Create a new instance of the model being queried.
     *
     * @param  array  $attributes
     * @return \Tools4Schools\SDK\Graph\Model
     */
    public function newModelInstance($attributes = [])
    {
        return $this->model->newInstance($attributes);//->setConnection(
           // $this->query->getConnection()->getName()
      //  );
    }

    /**
     * Dynamically handle calls into the request instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $this->request->{$method}(...$parameters);

        return $this;
    }
}