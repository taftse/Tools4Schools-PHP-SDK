<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/06/2018
 * Time: 18:55
 */

namespace Tools4Schools\SDK\Graph;


use Tools4Schools\SDK\Request\Builder as RequestBuilder;

class Builder
{
    /**
     * The model being queried.
     *
     * @var \Tools4Schools\SDK\Graph\Model
     */
    protected $model;

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

        $this->request->setEndpoint($model->getEndpoint());

        return $this;
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($columns = [] )
    {

        $models = $this->getModels($columns);
        return $this->getModel()->newCollection($models);
    }

    /**
     * Get the hydrated models
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model[]
     */
    public function getModels($columns = ['*'])
    {
        return $this->model->hydrate(
            $this->request->get($columns)->all()
        )->all();
    }

    /**
     * Get the model instance being queried.
     *
     * @return \Tools4Schools\SDK\Graph\Model
     */
    public function getModel()
    {
        return $this->model;
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
     * Create a new instance of the model being queried.
     *
     * @param  array  $attributes
     * @return \Tools4Schools\SDK\Graph\Model
     */
    public function newModelInstance($attributes = [])
    {
        return $this->model->newInstance($attributes);//->setConnection(
            //$this->query->getConnection()->getName()
        //);
    }
}