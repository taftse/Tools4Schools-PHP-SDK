<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 24/06/2018
 * Time: 18:29
 */

namespace Tools4Schools\SDK;


use GuzzleHttp\Psr7\Request;

interface ConnectionInterface
{
    public function execute(Request $request);
}