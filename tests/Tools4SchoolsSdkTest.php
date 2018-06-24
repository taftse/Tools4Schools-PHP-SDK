<?php

namespace Tools4Schools\SDK\Tests;


use PHPUnit\Framework\TestCase;
use Tools4Schools\SDK\Tools4SchoolsSdk;

class Tools4SchoolsSdkTest extends TestCase
{
    /**@test*/
    function test_send_get_request_to_me_endpoint(){
        $client = new Tools4SchoolsSdk(['enable_beta_mode'=>true]);

        $response = $client->get('/me');

        dd($response);
    }
}