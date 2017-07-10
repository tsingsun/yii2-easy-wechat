Yii2 EasyWechat
===============

wechat extension for Yii2. this is base on [EasyWechat](https://easywechat.org) 

[![Latest Stable Version](https://poser.pugx.org/tsingsun/yii2-easy-wechat/v/stable.svg)](https://packagist.org/packages/tsingsun/yii2-easy-wechat)
[![Build Status](https://travis-ci.org/tsingsun/yii2-easy-wechat.png?branch=master)](https://travis-ci.org/tsingsun/yii2-easy-wechat)
[![Total Downloads](https://poser.pugx.org/tsingsun/yii2-easy-wechat/downloads.svg)](https://packagist.org/packages/tsingsun/yii2-easy-wechat)


Installation
----
```
    composer require --prefer-dist tsingsun/yii2-easy-wechat
```

Configuration
----

```php
'components' => [       
        'cache' => [
            'class'=>'yii\caching\FileCache',
            'keyPrefix' => 'yak',
        ],
        'wechat'=>[
            'class'=>'yii\easyWechat\Wechat',
            //the config is all most match the easyWechat office's config,
            //the diffenrece please see Notice
            'config'=>[                
                'debug'  => true,                
                'app_id'=>'',
                'secret'=>'',
                'token'=>'',
                'aes_key'=>'',
                'payment'=>[                   
                    'merchant_id'=>'',
                    'key'=>'',                    
                    'cert_path'=>'',
                    'key_path'=>'',                    
                    'notify_url'=>''

                ],               
                'oauth' => [
                    'scopes'   => ['snsapi_userinfo'],
                    'callback' => '/examples/oauth_callback.php',
                ],
                'guzzle' => [
                    'timeout' => 3.0, // 超时时间（秒）
                    //'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
                ],
                /**
                 * Cache
                 */
                'cache'=>[

                ],
            ],
        ],
        'log'=>[
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'maxFileSize'=> 200,
                    'levels' => [],
                    'logVars' => [],
                    'logFile' => '@runtime/logs/'.date('ymd').'.log',
                ],
            ]
        ],
    ]
```
#### Notice
There are some change to better match for yii 
* use Yii Logger component instead of EasyWechat default logger;
* use Yii Cache component instead of EasyWechat default Cache that based on \Doctrine\Common\Cache\Cache.

### how to Test

In the unit test process, also discovered the WeChat development debugging egg pain, because also combed the test better practice
The tests are centered in the test directory. Go to the directory [测试说明](./tests/README.md)
