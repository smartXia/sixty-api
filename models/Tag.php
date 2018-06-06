<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/14
 * Time: 下午6:00
 */
namespace app\models;
use Behat\Gherkin\Exception\Exception;
use yii\db\ActiveRecord;
use yii\db\Query;

class Tag extends ActiveRecord {
    /**
     * @return string 返回该AR类关联的数据表名
     */
    static function tableName()
    {
        return 'hi_tags';
    }

    public function all($id, $limit = 1000, $page = 1) {
        $offset = ($page - 1) * $limit;
        $query = new Query;
        $dataQuery = $query->select('*');
        try {
            $total = $dataQuery->from('hi_tags')->count();
            if ($id) {
                $tagData = $dataQuery->from('hi_tags')
                    ->where('id=:id', [':id' => $id])
                    ->all();
            } else {
                $tagData = $dataQuery->from('hi_tags')
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('create_time desc')
                    ->all();
            }
            if (count($tagData) >= 0) {
                $result = [
                    'total' => $total,
                    'data' => $tagData,
                    'ret' => 1
                ];
            } else {
                $result = [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '获取文章标签数据出错'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}