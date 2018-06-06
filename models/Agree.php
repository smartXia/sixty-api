<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/5/21
 * Time: 上午10:00
 */

namespace app\models;
use Behat\Gherkin\Exception\Exception;
use yii\db\ActiveRecord;
use yii\db\Query;

class Agree extends ActiveRecord
{
    /**
     * @return string 返回该AR类关联的数据表名
     */
    static function tableName()
    {
        return 'hi_agree';
    }

    public function getAgreeTotal($comment_id) {
        if (!$comment_id) {
            return [
                'ret' => 0,
                'data' => null,
                'msg' => '必要参数缺失'
            ];
        }
        $query = new Query;
        $dataQuery = $query->select('*');
        try {
            $total = $dataQuery->from('hi_agree')
                ->where('comment_id=:comment_id', [':comment_id' => $comment_id])
                ->andWhere(['=', 'like', '1'])
                ->count();
            return $total;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function getAgree($comment_id, $user_id) {
        if (!$comment_id || !$user_id) {
            return [
                'ret' => 0,
                'data' => null,
                'msg' => '必要参数缺失'
            ];
        }
        $query = new Query;
        $dataQuery = $query->select('*');
        try {
            $agree = $dataQuery->from('hi_agree')
                ->where('comment_id=:comment_id', [':comment_id' => $comment_id])
                ->andWhere('user_id=:user_id', [':user_id' => $user_id])
                ->all();
            if (count($agree) > 0) {
                $result = [
                    'data' => $agree[0],
                    'ret' => 1
                ];
            } else {
                $result = [
                    'data' => null,
                    'ret' => 1
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function addAgree($user_id, $comment_id) {
        $agreeData = $this->getAgree(intval($comment_id), intval($user_id));
        try {
            if ($agreeData['data']) {
                $agree = Agree::findOne($agreeData['data']['id']);
                $agree->like = $agreeData['data']['like'] == 1 ? 0 : 1;
                $res = $agree->update(false);
            } else {
                $agree = new Agree();
                $agree->user_id = $user_id;
                $agree->comment_id = $comment_id;
                $agree->like = 1;
                $res = $agree->insert();
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
                    'msg' => '点赞失败'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}