<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 24/06/2018
 * Time: 18:01
 */

namespace Tools4Schools\SDK\Graph;

use Tools4Schools\SDK\Request\Builder as RequestBuilder;

class Builder
{
    /**
     * The base request builder instance.
     *
     * @var Tools4Schools\SDK\Request\Builder
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