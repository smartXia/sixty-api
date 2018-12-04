<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/26
 * Time: 下午5:22
 */
namespace app\models;
use Behat\Gherkin\Exception\Exception;
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

    public function all($id, $weibo_uid = '', $limit = 1000, $page = 1) {
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
                    'data' => [
                        'items' => $userData,
                        'total' => $total
                    ],
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
        $model = new Users;
        $model -> nickname = $params['nickname'];
        $model -> status = $params['status'];
        $model -> avatar = $params['avatar'];
        $model -> weibo_uid = $params['weibo_uid'];
        try {
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

    public function login ($nickname, $pass) {
        $query = new Query;
        $dataQuery = $query->select(['id', 'nickname', 'password', 'avatar', 'status', 'created_at', 'updated_at', 'weibo_uid']);
        try {
            $userData = $dataQuery->from('hi_users')
                ->where('nickname=:nickname', [':nickname' => $nickname])
                ->all();
            if (count($userData) == 0) {
                return [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '用户不存在'
                ];
            }

            if ($userData[0]['nickname'] != 'SixtyDen') {
                return [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '不是管理员'
                ];
            }

            if ($userData[0]['password'] != $pass) {
                return [
                    'ret' => 0,
                    'data' => null,
                    'msg' => '密码错误'
                ];
            }

            return [
                'ret' => 0,
                'data' => $userData[0]
            ];
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}