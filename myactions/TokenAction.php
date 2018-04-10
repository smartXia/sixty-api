<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/3/11
 * Time: 下午3:17
 */
namespace app\myactions;
use yii\rest\Action;

class TokenAction extends Action
{
    public function run(){
        $client_appid=\YII::$app->request->get("client_appid",false);
        $client_appkey=\YII::$app->request->get("client_appkey",false);
        $model=$this->modelClass;
        if(!$client_appid || !$client_appkey)

        {
            return(new $model())->emptyToken();
        }
        else
        {
          $model=$model::findOne(["client_appid"=>$client_appid,"client_appkey"=>$client_appkey]);
          if($model){
              $model->client_token=\Yii::$app->security->generateRandomString();
              if($model->save())
              {
                  return $model->toToken();
              }
          }
            return(new $model())->emptyToken();
        }
    }
}