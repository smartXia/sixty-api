<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/12
 * Time: 下午10:18
 */
namespace app\controllers;

class ArticleController extends BaseController {
    public $modelClass = 'app\models\Article';

    function actionAll() {
        try {
            $model = $this->modelClass;
            $article = $model::find();
            $articleData =  $article
                ->where(['or', 'id=:id1', 'id=:id2'])
                ->addParams([':id1'=>1, ':id2'=>2])
                ->all();
            $total = $article->count();
            if ($article) {
                $result = [
                    'total' => $total,
                    'data' => $articleData,
                    'ret' => 1
                ];
            } else {
                $result = [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '获取文章数据出错'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}