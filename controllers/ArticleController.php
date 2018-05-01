<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/12
 * Time: 下午10:18
 */
namespace app\controllers;
use app\models\Article;

use Yii;

class ArticleController extends BaseController {
    public $modelClass = 'app\models\Article';

    function actionAll() {
        $request = Yii::$app->request;
        $articleModel = new Article();
        $id = $request->post('id');
        $limit = $request->post('limit') ? $request->post('limit') : 100;
        $page = $request->post('page') ? $request->post('page') : 1;
        return $articleModel->all($id, $limit, $page);
    }
}