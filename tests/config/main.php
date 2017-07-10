<?php
/**
 * Created by PhpStorm.
 * User: tsingsun
 * Date: 2017/1/13
 * Time: 下午2:22
 */

$params = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
//$db = yii\helpers\ArrayHelper::merge(
//    require(__DIR__ . '/db.php'),
//    require(__DIR__ . '/db-local.php')
//);
return [
    'id' => 'testapp',
    'params' => $params,
    'basePath' => dirname(__DIR__),
    'controllerMap'=>[
        'site'=>'yiiunit\extensions\easyWechat\ApiController',
    ],
    'bootstrap'=>['log'],
    'vendorPath'=>dirname(__DIR__).'/../vendor',
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cache' => [
            'class'=>'yii\caching\FileCache',
            'keyPrefix' => 'yak',
        ],
        'wechat'=>[
            'class'=>'yii\easyWechat\Wechat',
            'config'=>[
                /**
                 * Debug 模式，bool 值：true/false
                 *
                 * 当值为 false 时，所有的日志都不会记录
                 */
                'debug'  => true,
                /**
                 * 账号基本信息，请从微信公众平台/开放平台获取
                 */
                'app_id'=>'',
                'secret'=>'',
                'token'=>'',
                'aes_key'=>'',
                'payment'=>[
                    //=======【基本信息设置】=====================================
                    /**
                     * APPID：绑定支付的APPID（必须配置，开户邮件中可查看）
                     * MCHID：商户号（必须配置，开户邮件中可查看）
                     * KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
                     * 设置地址：https://pay.weixin.qq.com/index.php/account/api_cert
                     * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），
                     * 获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN
                     */
                    'merchant_id'=>'',
                    'key'=>'',
                    //=======【证书路径设置】=====================================
                    /**
                     * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，
                     * API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书）
                     */
                    'cert_path'=>'',// XXX: 绝对路径！！！！
                    'key_path'=>'',// XXX: 绝对路径！！！！
                    //=======【curl代理设置】===================================
                    /**
                     * 这里设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
                     * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
                     * 默认CURL_PROXY_HOST=0.0.0.0和CURL_PROXY_PORT=0，此时不开启代理（如有需要才设置）
                     */
//                            'curl_proxy_host'=>'0.0.0.0',
//                            'curl_proxy_port'=> 0,
                    //=======【上报信息配置】===================================
                    /**
                     * 接口调用上报等级，默认紧错误上报（注意：上报超时间为【1s】，上报无论成败【永不抛出异常】，
                     * 不会影响接口调用流程），开启上报之后，方便微信监控请求调用的质量，建议至少
                     * 开启错误上报。
                     * 上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
                     */
//                            'report_levenl'=> 1,
                    /**
                     * 微信支付回调地址
                     */
                    'notify_url'=>''

                ],
                /**
                 * OAuth 配置
                 *
                 * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
                 * callback：OAuth授权完成后的回调页地址
                 */
                'oauth' => [
                    'scopes'   => ['snsapi_userinfo'],
                    'callback' => '/examples/oauth_callback.php',
                ],

                /**
                 * 日志配置,如果不配置，则默认采用Yii log
                 *
                 * level: 日志级别, 可选为：
                 *         debug/info/notice/warning/error/critical/alert/emergency
                 * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
                 * file：日志文件位置(绝对路径!!!)，要求可写权限
                 */
                'log' => [
                    'level'      => 'debug',
                    'permission' => 0777,
                    'file'       => '/tmp/easywechat.log',
                ],
                /**
                 * Guzzle 全局设置
                 *
                 * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
                 */
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
];