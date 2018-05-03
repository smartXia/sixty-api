<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/14
 * Time: 下午5:59
 */
namespace app\controllers;
use app\models\Tag;

use Yii;

class TagController extends BaseController {
    public $modelClass = 'app\models\Tag';

    function actionAll() {
        $request = Yii::$app->request;
        $TagModel = new Tag();
        $id = $request->post('id');
        $limit = $request->post('limit') ? $request->post('limit') : 1000;
        $page = $request->post('page') ? $request->post('page') : 1;
        return $TagModel->all($id, $limit, $page);
    }
}