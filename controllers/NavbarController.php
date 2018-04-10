<?php
namespace app\controllers;
use yii\rest\ActiveController;
use yii\web\Response;

/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/8/30
 * Time: 下午11:01
 */

class NavbarController extends BaseController
{
    public $modelClass = 'app\M\NavBar';
}