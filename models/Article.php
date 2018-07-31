<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/12
 * Time: 下午10:23
 */
namespace app\models;
use Prophecy\Exception\Exception;
use yii\db\ActiveRecord;
use yii\db\Query;

class Article extends ActiveRecord {
    /**
     * @return string 返回该AR类关联的数据表名
     */
    static function tableName()
    {
        return 'hi_article';
    }

    public function all($id, $limit = 1000, $page = 1) {
        $offset = ($page - 1) * $limit;
        $query = new Query;
        $dataQuery = $query->select('*');
        $total = $dataQuery->from('hi_article')->count();
        try {
            if ($id) {
                $articleData = $dataQuery->from('hi_article')
                    ->where('id=:id', [':id' => $id])
                    ->all();
            } else {
                $articleData = $dataQuery->from('hi_article')
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('create_time desc')
                    ->all();
            }
            if (count($articleData) >= 0) {
                $result = [
                    'data' => [
                        'items' => $articleData,
                        'total' => $total
                    ],
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

    public function addArticle($id, $title, $category_id = 0, $introduction, $nickname, $cover_picture, $content, $tag_ids) {
        try {
            if ($id) {
                $articleData = $this->all(intval($id));
                if (count($articleData['data']) == 0) {
                    return [
                        'ret' => 0,
                        'data' => null,
                        'msg' => '该文章不存在'
                    ];
                }
                $articleUpdate = Article::findOne($id);
                $articleUpdate->title = $title;
                $articleUpdate->category_id = $category_id;
                $articleUpdate->introduction = $introduction;
                $articleUpdate->nickname = $nickname;
                $articleUpdate->cover_picture = $cover_picture;
                $articleUpdate->content = $content;
                $articleUpdate->tag_ids = $tag_ids;
                $res = $articleUpdate->update(false);

            } else {
                $articleAdd = new Article();
                $articleAdd->title = $title;
                $articleAdd->category_id = $category_id;
                $articleAdd->introduction = $introduction;
                $articleAdd->nickname = $nickname;
                $articleAdd->cover_picture = $cover_picture;
                $articleAdd->content = $content;
                $articleAdd->tag_ids = $tag_ids;
                $res = $articleAdd->insert();
            }
            if ($res) {
                $result = [
                    'data' => $res,
                    'ret' => 1
                ];
            } else {
                $result = [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '操作失败'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function deleteArticle($id) {
        try {
            if (!$id) {
                return [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '必要参数缺失'
                ];
            }
            $articleData = $this->all(intval($id));
            if (count($articleData['data']) == 0) {
                return [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '该文章不存在'
                ];
            }
            $articleDelete = Article::findOne($id);
            $res = $articleDelete->delete();
            if ($res) {
                $result = [
                    'data' => $res,
                    'ret' => 1
                ];
            } else {
                $result = [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '删除成功'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}