<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/14
 * Time: 下午5:59
 */
namespace app\controllers;

class TagController extends BaseController {
    public $modelClass = 'app\models\Tag';

    function actionAll() {
        try {
            $model = $this->modelClass;
            $article = $model::find();
            $tagData =  $article
                /*->where(['or', 'id=:id1', 'id=:id2'])
                ->addParams([':id1'=>1, ':id2'=>2])*/
                ->all();
            $total = $article->count();
            if ($article) {
                $result = [
                    'total' => $total,
                    'data' => $tagData,
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