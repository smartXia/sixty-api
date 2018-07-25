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

    function actionAdd() {
        $request = Yii::$app->request;
        $TagModel = new Tag();
        $id= $request->post('id');
        $tag_name = $request->post('name');
        $tag_color = $request->post('color') ? $request->post('color') : 'green';
        if (!$tag_name || $tag_name === '') {
            return [
                'ret' => 0,
                'data' => null,
                'msg' => '标签名错误'
            ];
        }
        return $TagModel->addTag($id, $tag_name, $tag_color);
    }

    function actionDel() {
        $request = Yii::$app->request;
        $TagModel = new Tag();
        $id= $request->post('id');
        return $TagModel->deleteTag($id);
    }

}