<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/13
 * Time: 下午1:19
 */
use app\functions\Error;

class CommonCheck {
    public function __construct() {
        $this->error = new Error();
    }

    protected function _exception($err)
    {
        throw new \Exception($err['msg'], $err['code']);
    }

    protected function _success($data = null)
    {
        if (!$data === null) {
            return array('ret' => 1);
        }

        return array('ret' => 1, 'data' => $data);
    }
}