<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/06/2018
 * Time: 14:32
 */

namespace Tools4Schools\SDK\Oauth2;


interface CredentialFetcherInterface
{
    /**
     * Fetches the auth tokens based on the current state.
     *
     * @return array a hash of auth tokens
     */
    public function fetchAuthToken();

}