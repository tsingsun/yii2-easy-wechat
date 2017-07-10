<?php
/**
 * Created by PhpStorm.
 * User: tsingsun
 * Date: 2017/7/10
 * Time: 下午7:23
 */

namespace yiiunit\extensions\easyWechat;

use yii\easyWechat\Cache;

class CacheTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockApplication();
    }

    public function testConstruct()
    {
        $config = '';
        $c = new Cache($config);
        $this->assertInstanceOf(\yii\caching\Cache::className(),$c->getCache());
        $config = [
            'class'=>'yii\caching\FileCache',
            'keyPrefix' => 'yak',
        ];
        $c = new Cache($config);
        $this->assertInstanceOf(\yii\caching\Cache::className(),$c->getCache());
        $this->assertEquals('yak',$c->getCache()->keyPrefix);
    }
}
