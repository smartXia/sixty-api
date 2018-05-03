<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/12
 * Time: 下午10:23
 */
namespace app\models;
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