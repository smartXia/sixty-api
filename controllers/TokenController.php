<?php
namespace app\controllers;
use yii\rest\ActiveController;
use yii\web\Response;

/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/3/11
 * Time: 下午3:02
 */
class TokenController extends ActiveController
{
    public $modelClass="app\M\Clients";

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    function actions()
    {
        return [
            'index' => [
                'class' => 'app\myactions\TokenAction',
                'modelClass' => $this->modelClass,
            ]
            ];
    }
}