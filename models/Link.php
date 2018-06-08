<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/6/6
 * Time: 上午10:55
 */
namespace app\models;
use Behat\Gherkin\Exception\Exception;
use yii\db\ActiveRecord;
use yii\db\Query;

class Link extends ActiveRecord {
    /**
     * @return string 返回该AR类关联的数据表名
     */
    static function tableName()
    {
        return 'hi_link';
    }

    public function all($id, $type, $limit = 1000, $page = 1) {
        $offset = ($page - 1) * $limit;
        $query = new Query;
        $dataQuery = $query->select('*');
        $total = $dataQuery->from('hi_link')->count();
        try {
            if ($id) {
                $linkData = $dataQuery->from('hi_link')
                    ->where('id=:id', [':id' => $id])
                    ->andWhere('type=:type', [':type' => $type])
                    ->all();
            } else {
                $linkData = $dataQuery->from('hi_link')
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('create_time desc')
                    ->where('type=:type', [':type' => $type])
                    ->all();
            }
            if (count($linkData) >= 0) {
                $result = [
                    'total' => $total,
                    'data' => $linkData,
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

    public function addLink($logo_url, $nickname, $description, $link, $type) {
        try {
            $linkModel = new Link();
            $linkModel->logo_url = $logo_url;
            $linkModel->nickname = $nickname;
            $linkModel->description = $description;
            $linkModel->link = $link;
            $linkModel->type = $type;
            $res = $linkModel->insert();
            if ($res) {
                $result = [
                    'data' => $res,
                    'ret' => 1
                ];
            } else {
                $result = [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '添加友情链接数据失败'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}