<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 29/06/2018
 * Time: 16:25
 */

namespace Tools4Schools\SDK\Oauth2;


use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class Tools4SchoolsResourceOwner implements ResourceOwnerInterface
{
    /**
     * Returns the identifier of the authorized resource owner.
     *
     * @return mixed
     */
    public function getId()
    {
        throw new \BadMethodCallException('Method not implemented yet.');
    }
    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        throw new \BadMethodCallException('Method not implemented yet.');
    }
}