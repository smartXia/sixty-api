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
            $res = $http->httpPost('POST',$url,$params);
            $res->getBody()->getContents();
            if ($res && $res['uid']) {
                $result = [
                    'data' => $res,
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
            $res = $http->httpPost('GET', $url);
            $res->getBody()->getContents();
            if ($res && $res['id']) {
                $result = [
                    'data' => $res,
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