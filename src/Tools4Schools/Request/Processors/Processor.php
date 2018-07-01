<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 29/06/2018
 * Time: 19:01
 */

namespace Tools4Schools\SDK\Request\Processors;


use Tools4Schools\SDK\Request\Builder;

class Processor
{
    /**
     * Process the results of a "get" request.
     *
     * @param  \Tools4Schools\SDK\Request\Builder  $request
     * @param  array  $results
     * @return array
     */
    //processSelect
    public function processGet(Builder $request, $results)
    {
       return [json_decode($results->getBody(),true)];
    }

}