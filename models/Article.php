<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/4/12
 * Time: 下午10:23
 */
namespace app\models;
use yii\db\ActiveRecord;

class Article extends ActiveRecord {
    /**
     * @return string 返回该AR类关联的数据表名
     */
    static function tableName()
    {
        return 'hi_article';
    }
}