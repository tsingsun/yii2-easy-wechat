<?php
/**
 * Created by PhpStorm.
 * User: tsingsun
 * Date: 2017/7/10
 * Time: 下午7:23
 */

namespace yiiunit\extensions\easyWechat;

use EasyWeChat\Support\Log;

class WechatTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockApplication();
    }

    public function testAccessToken()
    {
        $accessToken = $this->wechat->app->access_token;
        $a1 = $accessToken->getToken();
        sleep(10);
        $a2 = $accessToken->getToken();
        $this->assertEquals($a1,$a2);
        $a3 = $accessToken->getToken(true);
        $this->assertNotEquals($a3,$a1);
    }

    public function testDefaultLogger()
    {
        Log::error('test',['method'=>'test']);
        //please the easy wechat log
        $this->assertTrue(true);
    }

    public function testYiiLogger()
    {
        $config = [

        ];
        $w = $this->wechat->createEasyWechat($config);
        $rf = new \ReflectionProperty($this->wechat,'app');
        $rf->setAccessible(true);
        $rf->setValue($this->wechat,$w);
        Log::error('test Yii Log',['method'=>'test']);
        //please the yii log
        $this->assertTrue(true);
    }
}
