<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/5/12
 * Time: 下午4:34
 */
namespace app\models;
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

    public function comment($article_id, $limit, $page, $children_limit, $children_page) {
        if (!$article_id) {
            return [
                'ret' => 0,
                'data' => null,
                'msg' => '必要参数缺失'
            ];
        }
        $offset = ($page - 1) * $limit;
        $query = new Query;
        $dataQuery = $query->select('*');
        try {
            $total = $dataQuery->from('hi_comment')
                ->where('article_id=:article_id', [':article_id' => $article_id])
                ->andWhere(['=', 'parent_id', 0])
                ->count();
            $articleCommentData = $dataQuery->from('hi_comment')
                ->where('article_id=:article_id', [':article_id' => $article_id])
                ->andWhere(['=', 'parent_id', 0])
                ->limit($limit)
                ->offset($offset)
                ->all();
            if (count($articleCommentData) >= 0) {
                foreach ($articleCommentData as $key => $comment) {
                    /*在循环里请求数据库，这做法最好不要用，我这里严格限制了每次10条数据，可能是因为w我太懒了*/
                    $childrenCommentData = $this->childrenComment($comment['id'], $children_limit, $children_page);
                    if ($childrenCommentData['ret'] == 1) {
                        $articleCommentData[$key]['childrenTotal'] = $childrenCommentData['total'];
                        $articleCommentData[$key]['children'] = $childrenCommentData['data'];
                    }
                }
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

    public function addComment($article_id, $user_id, $parent_id, $reply_id, $content) {
        try {
            $customer = new Comment();
            $customer->article_id = $article_id;
            $customer->user_id = $user_id;
            $customer->parent_id = $parent_id;
            $customer->reply_id = $reply_id;
            $customer->content = $content;
            $res = $customer->insert();
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