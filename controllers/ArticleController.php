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
        $limit = $request->post('limit') ? $request->post('limit') : 1000;
        $page = $request->post('page') ? $request->post('page') : 1;
        return $articleModel->all($id, $limit, $page);
    }

    function actionFilter() {
        $request = Yii::$app->request;
        $articleModel = new Article();
        $filter = $request->post('filter');
        $limit = $request->post('limit') ? $request->post('limit') : 1000;
        $page = $request->post('page') ? $request->post('page') : 1;
        return $articleModel->flter($filter, $limit, $page);
    }

    function actionAdd() {
        $request = Yii::$app->request;
        $articleModel = new Article();
        $id= $request->post('id');
        $title = $request->post('title');
        $category_id = $request->post('category_id');
        $music_id = $request->post('music_id');
        $introduction = $request->post('introduction');
        $nickname = $request->post('nickname');
        $cover_picture = $request->post('cover_picture');
        $content = $request->post('content');
        $tag_ids = $request->post('tag_ids');
        return $articleModel->addArticle($id, $title, $music_id, $category_id, $introduction, $nickname, $cover_picture, $content, $tag_ids);
    }

    function actionDel() {
        $request = Yii::$app->request;
        $articleModel = new Article();
        $id= $request->post('id');
        return $articleModel->deleteArticle($id);
    }
}
