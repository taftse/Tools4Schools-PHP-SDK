<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 24/06/2018
 * Time: 16:39
 */

namespace Tools4Schools\SDK\Models;

use Tools4Schools\SDK\Graph\Model as GraphModel;

class User Extends GraphModel
{
    public function me(){
        $this->setEndpoint('/me');
        return $this;
    }
}