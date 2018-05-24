<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/5/12
 * Time: 下午4:33
 */
namespace app\controllers;
use app\models\Comment;
use app\models\Users;
use app\models\Agree;

use Yii;

class CommentController extends BaseController {
    public $modelClass = 'app\models\Comment';

    function actionAll() {
        $request = Yii::$app->request;
        $commentModel = new Comment();
        $article_id = $request->post('article_id');
        $limit = $request->post('limit') ? $request->post('limit') : 1000;
        $page = $request->post('page') ? $request->post('page') : 1;
        $children_limit = $request->post('children_limit') ? $request->post('children_limit') : 1000;
        $children_page = $request->post('children_page') ? $request->post('children_page') : 1;
        return $commentModel->comment($article_id, $limit, $page, $children_limit, $children_page);
    }

    function actionChildren() {
        $request = Yii::$app->request;
        $commentModel = new Comment();
        $parent_id = $request->post('parent_id');
        $limit = $request->post('limit') ? $request->post('limit') : 1000;
        $page = $request->post('page') ? $request->post('page') : 1;
        return $commentModel->childrenComment($parent_id, $limit, $page);
    }

    function actionAdd() {
        $request = Yii::$app->request;
        $article_id = $request->post('article_id');
        $user_id = $request->post('user_id');
        $parent_user_id = $request->post('parent_user_id');
        $parent_id = $request->post('parent_id') ? $request->post('parent_id') : 0;
        $reply_id = $request->post('reply_id') ? $request->post('reply_id') : 0;
        $content = $request->post('content');
        if (!$article_id || !$user_id || !$content) {
            return [
                'ret' => 0,
                'data' => null,
                'msg' => '必要参数缺失'
            ];
        }
        $userModel = new Users;
        $commentModel = new Comment();
        $userResult = $userModel->all($user_id);
        $parentUserResult = $userModel->all($parent_user_id);
        $userData = $userResult && $userResult['data'] ? $userResult['data'][0] : [];
        $parentUserData = $parentUserResult && $parentUserResult['data'] ? $parentUserResult['data'][0] : [];
        $user_nickname = $userData['nickname'];
        $user_avatar = $userData['avatar'];
        $parent_user_nickname = $parentUserData['nickname'];
        return $commentModel->addComment($article_id, $user_id, $parent_id, $reply_id, $content, $user_nickname, $user_avatar, $parent_user_nickname);
    }

    function actionLike() {
        $request = Yii::$app->request;
        $agreeModel = new Agree();
        $user_id = $request->post('user_id');
        $comment_id = $request->post('comment_id');
        return $agreeModel->addAgree($user_id, $comment_id);
    }

    function actionGetlike() {
        $request = Yii::$app->request;
        $agreeModel = new Agree();
        $user_id = $request->post('user_id');
        $comment_id = $request->post('comment_id');
        return $agreeModel->getAgree($comment_id, $user_id);
    }
}