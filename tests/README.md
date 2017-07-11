## 测试说明

在测试项目中包含了两个类型的测试,单元测试与运行项目,这两个项目在配置上存在一定的共用.单元测试的先行略过

现在主要说运行项目.
### 运行项目
运行项目其实就是Yii2的web项目,只保证最低可运行调试的配置,具体的请看项目,现在来看运行的微信配置.

### 主配置文件
````php
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
                 * Cache use yii config
                 */
                'cache'=>[               
                    'class'=>'xxx',
                ],
            ],
        ],
````
可以看到现在的包公众号配置与支付配置是合并在一个配置文件中.

### 接口控制器

ApiController
````php
class ApiController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @var Wechat;
     */
    protected $wechat;

    public function init()
    {
        parent::init();
        $this->wechat = Yii::$app->get('wechat');
    }


    public function actionIndex()
    {
        $this->wechat->app->server->setMessageHandler(function ($message) {
        
                    return "hello！欢迎关注我!";
                });
        $this->wechat->app->server->serve()->send();
    }
}
````
Index方法即入微信接口地址,在这个方法中实现所有消息与事件的处理.

### 微信开发配置

#### 内网转发工具 Ngrok

相信和很多新手一样，遇到的第一件事就是如何配置url，主要是微信的80/443端口的蛋疼限制,而公司网络的80端口要么是未开通,要么就是被占用.导致与微信间的通信测试很麻烦.
ngrok正是为了解决这类问题,到 www.ngrok.cc 去注册账号,开通免费隧道,官网也有视频教程.
按教程设置下来.就可以通过sunny clientid xxx 启动服务.外网就可以通过域名访问本地80端口

在我本机上,内网转发在很短的时间就需要重启,好像是自动中断了,但可实现通信.希望各位不会遇到我这样的问题.

#### 微信公众平台-测试号管理

解决了url问题,接下来就可以借助微信的测试平台进行开发了.
1. 首先申请测试号,入口 http://mp.weixin.qq.com/debug/cgi-bin/sandboxinfo?action=showinfo&t=sandbox/index
2. 进入申请成功后的页面,将ngrok获取的域名如.http://xxx.ngrok.cc/wechat/index,填写到接口配置信息中,
提交.提示成功后就可以进行消息通信了.
3. 如果不成功,请查看index方法.最基本的写法只需要调用 $this->wechat->server->serve()自动实现验证.
4. 扫描公众号的二维码,把自己变成该测试公众号的粉,然后就可以进行通信了.

