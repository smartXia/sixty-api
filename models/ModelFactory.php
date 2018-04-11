<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/9/9
 * Time: 下午4:23
 */
namespace app\models;

use yii\db\ActiveRecord;

class ModelFactory extends ActiveRecord
{
    public static $_tableName;

    static function tableName()
    {
        return self::$_tableName;
    }

    public static function loadModel($tableName) {
        self::$_tableName = $tableName;
        return new ModelFactory();
    }
}