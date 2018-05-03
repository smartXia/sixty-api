<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/5/2
 * Time: 下午10:08
 */

namespace app\models;

use app\functions\Http;
use yii\db\ActiveRecord;

class Token extends ActiveRecord {
    public function getToken ($url, $params) {
        $http = new Http();
        try {
            $query = $http->httpPost($url,$params);
            $res = $query->getBody()->getContents();
            if ($res) {
                $result = [
                    'data' => json_decode($res),
                    'ret' => 1
                ];
            } else {
                $result = [
                    'ret' => -1,
                    'data' => null,
                    'msg' => '用户授权失败'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
    public function getUser ($url) {
        $http = new Http();
        try {
            $query = $http->httpGet($url);
            $res = $query->getBody()->getContents();
            if ($res) {
                $result = [
                    'data' => json_decode($res),
                    'ret' => 1
                ];
            } else {
                $result = [
                    'ret' => -1,
                    'data' => null,
                    'msg' => '获取用户微博信息失败'
                ];
            }
            return $result;
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}