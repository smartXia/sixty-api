<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/5/12
 * Time: 下午4:34
 */
namespace app\models;
use app\models\Agree;
use Behat\Gherkin\Exception\Exception;
use yii\db\ActiveRecord;
use yii\db\Query;

class Comment extends ActiveRecord
{
    /**
     * @return string 返回该AR类关联的数据表名
     */
    static function tableName()
    {
        return 'hi_comment';
    }

    public function comment($article_id, $limit, $page, $children_limit, $children_page, $type) {
        /*if ($article_id == null) {
            return [
                'ret' => 0,
                'data' => null,
                'msg' => '必要参数缺失'
            ];
        }*/
        $offset = ($page - 1) * $limit;
        $query = new Query;
        $dataQuery = $query->select('*');
        try {
            if ($article_id == 0) {
                $total = $dataQuery->from('hi_comment')
                    ->where('type=:type', [':type' => $type])
                    ->andWhere(['=', 'parent_id', 0])
                    ->count();
                $articleCommentData = $dataQuery->from('hi_comment')
                    ->where('type=:type', [':type' => $type])
                    ->andWhere(['=', 'parent_id', 0])
                    ->limit($limit)
                    ->offset($offset)
                    ->all();
            } else {
                $total = $dataQuery->from('hi_comment')
                    ->where('article_id=:article_id', [':article_id' => $article_id])
                    ->andWhere('type=:type', [':type' => $type])
                    ->andWhere(['=', 'parent_id', 0])
                    ->count();
                $articleCommentData = $dataQuery->from('hi_comment')
                    ->where('article_id=:article_id', [':article_id' => $article_id])
                    ->andWhere('type=:type', [':type' => $type])
                    ->andWhere(['=', 'parent_id', 0])
                    ->limit($limit)
                    ->offset($offset)
                    ->all();
            }
            if (count($articleCommentData) >= 0) {
                $agreeModel = new Agree;
                foreach ($articleCommentData as $key => $comment) {
                    /*在循环里请求数据库，这做法最好不要用，我这里严格限制了每次10条数据，可能是因为我太懒了*/
                    $agreeTotal = $agreeModel->getAgreeTotal($comment['id']);
                    $articleCommentData[$key]['like'] = $agreeTotal;
                    $childrenCommentData = $this->childrenComment($comment['id'], $children_limit, $children_page);
                    if ($childrenCommentData['ret'] == 1) {
                        $articleCommentData[$key]['childrenTotal'] = $childrenCommentData['total'];
                        $articleCommentData[$key]['children'] = $childrenCommentData['data'];
                    }
                }
                $articleComment['total'] = $total;
                $articleComment['data'] = $articleCommentData;
                $result = [
                    'total' => $total,
                    'data' => $articleCommentData,
                    'ret' => 1
                ];
            } else {
                $result = [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '获取评论数据出错'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function childrenComment($parent_id, $limit, $page) {
        $offset = ($page - 1) * $limit;
        $query = new Query;
        $dataQuery = $query->select('*');
        $total = $dataQuery->from('hi_comment')
            ->where(['!=', 'parent_id', 0])
            ->andWhere('parent_id=:parent_id', [':parent_id' => $parent_id])
            ->count();
        try {
            if (!$parent_id) {
                return [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '必要参数缺失'
                ];
            }
            $childrenCommentData = $dataQuery->from('hi_comment')
                ->where('parent_id=:parent_id', [':parent_id' => $parent_id])
                ->limit($limit)
                ->offset($offset)
                ->all();
            if (count($childrenCommentData) >= 0) {
                $agreeModel = new Agree;
                /*在循环里请求数据库，这做法最好不要用，我这里严格限制了每次10条数据，可能是因为我太懒了*/
                foreach ($childrenCommentData as $key=>$comment) {
                    $agreeTotal = $agreeModel->getAgreeTotal($comment['id']);
                    $childrenCommentData[$key]['like'] = $agreeTotal;
                }
                $result = [
                    'total' => $total,
                    'data' => $childrenCommentData,
                    'ret' => 1
                ];
            } else {
                $result = [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '获取评论数据出错'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function addComment($article_id, $user_id, $parent_id = 0, $reply_id = 0, $content, $user_nickname = '', $user_avatar = '', $parent_user_nickname = '', $type = 'article') {
        try {
            $comment = new Comment();
            $comment->article_id = $article_id;
            $comment->user_id = $user_id;
            $comment->parent_id = $parent_id;
            $comment->reply_id = $reply_id;
            $comment->content = $content;
            $comment->user_nickname = $user_nickname;
            $comment->user_avatar = $user_avatar;
            $comment->parent_user_nickname = $parent_user_nickname;
            $comment->type = $type;
            $res = $comment->insert();
            if ($res) {
                $result = [
                    'data' => $res,
                    'ret' => 1
                ];
            } else {
                $result = [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '添加评论数据失败'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}