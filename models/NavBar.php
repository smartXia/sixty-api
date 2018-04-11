<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/8/30
 * Time: 下午10:57
 */
namespace app\models;
use yii\db\ActiveRecord;

class NavBar extends ActiveRecord
{
    /**
     * @return string 返回该AR类关联的数据表名
     */
    static function tableName()
    {
        return 'navbar';
    }
}