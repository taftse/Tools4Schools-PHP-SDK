<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 24/06/2018
 * Time: 17:48
 */

namespace Tools4Schools\SDK\Concerns;


trait HasRelationships
{
    /**
     * The loaded relationships for the model.
     *
     * @var array
     */
    protected $relations = [];
}