<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/2/26
 * Time: 下午3:31
 */
namespace app\models;

use app\M\NewsClass;
use yii\db\ActiveRecord;

class News extends ActiveRecord
{
    /**
     * @return string 返回该AR类关联的数据表名
     */
    public static function tableName()
    {
        return 'news';
    }
    function getNewsClass()
    {
        return $this->hasOne(NewsClass::className(),["class_id"=>"news_classid"]);
    }
}