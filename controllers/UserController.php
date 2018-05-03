<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/27
 * Time: 下午5:44
 */
namespace app\controllers;
use app\models\Users;
use Yii;

class UserController extends BaseController {
    public $modelClass = 'app\models\Users';

    public function actionAll() {
        $request = Yii::$app->request;
        $userModel = new Users();
        $id = $request->post('id');
        $weibo_uid = $request->post('weibo_uid');
        $limit = $request->post('limit') ? $request->post('limit') : 1000;
        $page = $request->post('page') ? $request->post('page') : 1;
        return $userModel->all($id, $weibo_uid, $limit, $page);
    }

    public function actionRegister() {
        $request = Yii::$app->request;
        $userModel = new Users();
        $params = $request->post();
        $nickname = $params['nickname'];
        $weibo_uid = $params['weibo_uid'];
        if (!$nickname) {
            return $result = [
                'ret' => -1,
                'data' => false,
                'msg' => '用户昵称不能为空'
            ];
        }
        if (!$weibo_uid) {
            return $result = [
                'ret' => -1,
                'data' => false,
                'msg' => '必须参数缺失'
            ];
        }
        return $userModel->register($params);
    }
}