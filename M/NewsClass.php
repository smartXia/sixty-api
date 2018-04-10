<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/2/26
 * Time: 下午4:15
 */
namespace app\M;
use yii\db\ActiveRecord;

class NewsClass extends ActiveRecord
{
    public static function tableName()
    {
        return 'news_class';
    }
}