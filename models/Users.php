<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/2/26
 * Time: 下午5:22
 */
namespace app\models;
use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
    static function tableName()
    {
        return "users";
    }
    function scenarios()
    {
        return [
            "default"=> ["user_name","user_pass"]
        ];
    }
}