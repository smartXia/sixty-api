<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/2/19
 * Time: 下午5:44
 */
namespace app\controllers;
use app\M\News;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;

class NewsController extends ActiveController
{
    public $modelClass = 'app\M\News';
    public function init()
    {
        $this->enableCsrfValidation= false;
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }
    function actionDo()
    {
        $news = new News();
        var_export($news::find()->joinWith("newsClass")->all()[0]);

    }
}