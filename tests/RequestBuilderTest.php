<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 29/06/2018
 * Time: 15:44
 */

namespace Tools4Schools\Tests\SDK;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Tools4Schools\SDK\Request\Builder;

class RequestBuilderTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testBasicGet()
    {
        $builder = $this->getBuilder();
        $builder->get()->endpoint('user');

        dd($builder);
    }

    protected function getBuilder()
    {
        return new Builder(m::mock('Tools4Schools\SDK\ConnectionInterface'));
    }

}