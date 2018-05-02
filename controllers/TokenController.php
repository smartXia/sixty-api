<?php
namespace app\controllers;
use app\models\Token;
use Yii;
use yii\rest\ActiveController;

/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/3/11
 * Time: 下午3:02
 */
class TokenController extends ActiveController
{
    public $modelClass="app\models\Token";

    public function actionGet() {
        $request = Yii::$app->request;
        $url = $request->post('url');
        $client_id = $request->post('client_id');
        $client_secret = $request->post('client_secret');
        $grant_type = $request->post('grant_type');
        $code = $request->post('code');
        $redirect_uri = $request->post('redirect_uri');
        $params = [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => $grant_type,
            'code' => $code,
            'redirect_uri' => $redirect_uri
        ];
        $token = new Token;
        return $token ->getToken($url, $params);
    }

    public function actionUser() {
        $request = Yii::$app->request;
        $url = $request->post('url');
        $access_token = $request->post('access_token');
        $uid = $request->post('uid');
        $url = $url.'?access_token='.$access_token.'&uid='.$uid;
        $token = new Token;
        if ($access_token && $uid) {
            return $token ->getUser($url);
        }
    }
}