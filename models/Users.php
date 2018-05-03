<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/26
 * Time: 下午5:22
 */
namespace app\models;
use yii\base\Model;
use yii\db\ActiveRecord;
use \yii\db\Query;

class Users extends ActiveRecord {
    static function tableName()
    {
        return 'hi_users';
    }
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function all($id, $weibo_uid, $limit = 100, $page = 1) {
        $offset = ($page - 1) * $limit;
        $query = new Query;
        $dataQuery = $query->select(['id', 'nickname', 'avatar', 'status', 'created_at', 'updated_at', 'weibo_uid']);
        try {
            $total = $dataQuery->from('hi_users')->count();
            if ($id) {
                $userData = $dataQuery->from('hi_users')
                    ->where('id=:id', [':id' => $id])
                    ->all();
            } elseif ($weibo_uid) {
                $userData = $dataQuery->from('hi_users')
                    ->where('weibo_uid=:weibo_uid', [':weibo_uid' => $weibo_uid])
                    ->all();
            } else {
                $userData = $dataQuery->from('hi_users')
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('created_at desc')
                    ->all();
            }
            if (count($userData) >= 0) {
                $result = [
                    'total' => $total,
                    'data' => $userData,
                    'ret' => 1
                ];
            } else {
                $result = [
                    'ret' => -1,
                    'data' => null,
                    'msg' => '获取用户数据出错'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function register ($params) {
        try {
             $model = new Users;
             $model -> nickname = $params['nickname'];
             $model -> status = $params['status'];
             $model -> avatar = $params['avatar'];
             $model -> weibo_uid = $params['weibo_uid'];
             $result = $model->save();
             if ($result > 0) {
                 $result = [
                     'data' => $result,
                     'ret' => 1
                 ];
             } else {
                 $result = [
                     'ret' => 0,
                     'data' => null,
                     'msg' => '插入数据失败'
                 ];
             }
             return $result;
         } catch (Exception $e) {
             echo 'Message: ' .$e->getMessage();
         }
    }
}