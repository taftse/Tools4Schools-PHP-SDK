<?php

namespace Tools4Schools\SDK\Tests;


use PHPUnit\Framework\TestCase;
use Tools4Schools\SDK\GraphClient;

class Tools4SchoolsSdkTest extends TestCase
{
    protected  $accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQzMzhhZGU0ZTgzNTVkNjliNTZmYTA4MDQ3NDI3ZmE5YzgzNTBhYWU3ODFiZTUzMDJmMTQxMWUwZmQ4MGJhMTBmOTZiNzVhNmY3Njg1Y2Q0In0.eyJhdWQiOiIyIiwianRpIjoiNDMzOGFkZTRlODM1NWQ2OWI1NmZhMDgwNDc0MjdmYTljODM1MGFhZTc4MWJlNTMwMmYxNDExZTBmZDgwYmExMGY5NmI3NWE2Zjc2ODVjZDQiLCJpYXQiOjE1Mjg5OTA2NDUsIm5iZiI6MTUyODk5MDY0NSwiZXhwIjoxNTYwNTI2NjQ1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.R_4rugICcyX8lN404m_SMmg4bnvbfL5YeFZNHT-Tgi1y-hLSjVFq4VDb4t0Qdle5QhuP91pqSjhEyJhLtzw_hntsteXk4uoEAtTPkblx0FvQKg9VoW7c_P6oxN8pAbmEDGL641U6ho1HaN39VuUNp7MoRwqCFbLu8hbBUTU6Iq833tR0OvIM-faZYkRXFb0mDFKPWziOt3WPcKvuOWW_msWDVvIpll5flgQNDyhQgdMhxagSoboh_kpNRoB37P9Nqi4j5xvaUx1OKACLHdFvGLToCJoep0X2vjls71L5gEvCSESe44BAD06qRDuNORZsN0Jwa1YWy0xWIiNOqgpN--bcKNT1DceHnApr-OP1u9xorLt5ytlXR-6Yq5JjI0P_o_m6eTxH0m6j_DqHdc6f51nKpQMR9gC0aAuqlcRiqCpyxPsT7ZvajXKi67P_v_4tZiodIEtdsG7cpxwFqy6dJsOHz264x-y52raSxskevoXoZAth20ypUEK6y5nVQv3TbxzApdMuBPrzed570oM0wmLaHnNnar3d-78wUfcTTyv01tAQ9PHvOB_nw6_f5xl5lutat7hJZOzwNZ2TAGEeZHR8DBoZqsl46W2cfvgSpuopWcSWl5r_TrO__Cr-yblDZ0TIlBGub85e_7zo-dcnK7wwdO2H_sw8JM76Xk92474";
    /**@test*/
    function test_send_get_request_to_me_endpoint(){
        $client = new GraphClient(['default_access_token'=>$this->accessToken,'enable_beta_mode'=>true]);

        $request = $client->createRequest('GET','me');
        $response = $client->sendRequest($request);
        dd($response);
    }


}