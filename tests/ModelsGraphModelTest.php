<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 24/06/2018
 * Time: 16:46
 */

namespace Tools4Schools\Tests\SDK;


use Mockery\Exception;
use PHPUnit\Framework\TestCase;
use Tools4Schools\SDK\Graph\Model;
use Tools4Schools\SDK\Tools4Schools;

class ModelsGraphModelTest extends TestCase
{
    protected  $accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQzMzhhZGU0ZTgzNTVkNjliNTZmYTA4MDQ3NDI3ZmE5YzgzNTBhYWU3ODFiZTUzMDJmMTQxMWUwZmQ4MGJhMTBmOTZiNzVhNmY3Njg1Y2Q0In0.eyJhdWQiOiIyIiwianRpIjoiNDMzOGFkZTRlODM1NWQ2OWI1NmZhMDgwNDc0MjdmYTljODM1MGFhZTc4MWJlNTMwMmYxNDExZTBmZDgwYmExMGY5NmI3NWE2Zjc2ODVjZDQiLCJpYXQiOjE1Mjg5OTA2NDUsIm5iZiI6MTUyODk5MDY0NSwiZXhwIjoxNTYwNTI2NjQ1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.R_4rugICcyX8lN404m_SMmg4bnvbfL5YeFZNHT-Tgi1y-hLSjVFq4VDb4t0Qdle5QhuP91pqSjhEyJhLtzw_hntsteXk4uoEAtTPkblx0FvQKg9VoW7c_P6oxN8pAbmEDGL641U6ho1HaN39VuUNp7MoRwqCFbLu8hbBUTU6Iq833tR0OvIM-faZYkRXFb0mDFKPWziOt3WPcKvuOWW_msWDVvIpll5flgQNDyhQgdMhxagSoboh_kpNRoB37P9Nqi4j5xvaUx1OKACLHdFvGLToCJoep0X2vjls71L5gEvCSESe44BAD06qRDuNORZsN0Jwa1YWy0xWIiNOqgpN--bcKNT1DceHnApr-OP1u9xorLt5ytlXR-6Yq5JjI0P_o_m6eTxH0m6j_DqHdc6f51nKpQMR9gC0aAuqlcRiqCpyxPsT7ZvajXKi67P_v_4tZiodIEtdsG7cpxwFqy6dJsOHz264x-y52raSxskevoXoZAth20ypUEK6y5nVQv3TbxzApdMuBPrzed570oM0wmLaHnNnar3d-78wUfcTTyv01tAQ9PHvOB_nw6_f5xl5lutat7hJZOzwNZ2TAGEeZHR8DBoZqsl46W2cfvgSpuopWcSWl5r_TrO__Cr-yblDZ0TIlBGub85e_7zo-dcnK7wwdO2H_sw8JM76Xk92474";


    public function setUp()
    {
        parent::setUp();

        new Tools4Schools([
            'enable_beta_mode'=>true,
            'access_token'=>$this->accessToken
        ]);
    }

    public function testAttributeManipulation()
    {
        $model = new GraphModelStub;
        $model->name = 'foo';
        $this->assertEquals('foo', $model->name);

        $this->assertTrue(isset($model->name));
        unset($model->name);
        $this->assertFalse(isset($model->name));
        // test mutation
        $model->list_items = ['name' => 'taylor'];
        $this->assertEquals(['name' => 'taylor'], $model->list_items);
        //$attributes = $model->getAttributes();
        //$this->assertEquals(json_encode(['name' => 'taylor']), $attributes['list_items']);
    }

    public function testGetAndSetEndpointOperations()
    {
        $model = new GraphModelStub;
        $this->assertEquals('stub', $model->getEndpoint());
        $model->setEndpoint('foo');
        $this->assertEquals('foo', $model->getEndpoint());
    }

    public function testGetModel()
    {
        $model = new GraphModelStub;
        $model->setEndpoint('me');
        try{
            dd($model->get());
        }catch (Exception $e)
        {
            dd($e);
        }
    }


}

class GraphModelStub extends Model {
    protected $endpoint = 'stub';
}