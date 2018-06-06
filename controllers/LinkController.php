<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/6/6
 * Time: 上午10:55
 */
namespace app\controllers;
use app\models\Link;

use Yii;

class LinkController extends BaseController {
    public $modelClass = 'app\models\Link';

    function actionAll() {
        $request = Yii::$app->request;
        $linkModel = new Link();
        $id = $request->post('id');
        $limit = $request->post('limit') ? $request->post('limit') : 1000;
        $page = $request->post('page') ? $request->post('page') : 1;
        return $linkModel->all($id, $limit, $page);
    }

    function actionAdd() {
        $request = Yii::$app->request;
        $logo_url = $request->post('logo_url');
        $nickname = $request->post('nickname');
        $description = $request->post('description');
        $link = $request->post('link');
        if (!$logo_url || !$nickname || !$link) {
            return [
                'ret' => 0,
                'data' => null,
                'msg' => '必要参数缺失'
            ];
        }
        $linkModel = new Link();
        return $linkModel->addLink($logo_url, $nickname, $description, $link);
    }
}