<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/06/2018
 * Time: 20:18
 */

namespace Tools4Schools\SDK\Graph\Concerns;


trait HasAttributes
{
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Set the array of model attributes. No checking is done.
     *
     * @param  array  $attributes
     * @param  bool  $sync
     * @return $this
     */
    public function setRawAttributes(array $attributes, $sync = false)
    {
        $this->attributes = $attributes;
        /*if ($sync) {
            $this->syncOriginal();
        }*/
        return $this;
    }
}