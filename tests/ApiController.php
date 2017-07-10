<?php
/**
 * Created by PhpStorm.
 * User: tsingsun
 * Date: 2017/1/17
 * Time: 下午6:37
 */

namespace yiiunit\extensions\easyWechat;

use Yii;
use yii\web\Controller;

class ApiController extends Controller
{

    public $enableCsrfValidation = false;
    /**
     * @var \yii\easyWechat\Wechat;
     */
    protected $wechat;

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

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