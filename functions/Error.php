<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/14
 * Time: 下午5:32
 */
namespace app\functions;

class Error
{
    private $properties = array(
        'UNKOWN_ERROR' => array(-1, '其它错误'),
        'INVALID_RPC_TOKEN' => array(-2, 'rpc token不合法'),
        'INVALID_APPKEY' => array(-3, 'appkey不合法'),
        'NOT_LOGIN' => array(-4, '需要登录'),
        'NO_ACCESS' => array(-5, '权限不足'),
        'EMPTY_REQUIRED_PARAMTER' => array(-6, '必须参数缺失'),
        'INVALID_TOKEN' => array(-7, 'token不合法'),
        'INVALID_VALIDATE_KEY' => array(-8, '校验的key不合法'),

        'GET_DATA_FAILED' => array(100, '数据获取失败'),

    );

    public function __get($key){
        if (array_key_exists($key, $this->properties)) {
            $property = $this->properties[$key];

            return array('ret' => -1, 'code' => $property[0], 'msg' => $property[1]);
        }
    }
}