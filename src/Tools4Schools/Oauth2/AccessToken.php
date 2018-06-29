<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 29/06/2018
 * Time: 13:46
 */

namespace Tools4Schools\SDK\Oauth2;


class AccessToken
{
    protected $accessToken;

    protected $refreshToken;

    protected $expiresIn;

    public function __construct($accessToken,$expiresIn,$refreshToken = null)
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->expiresIn = $expiresIn;
    }
}