<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/8/9
 * Time: 上午12:39
 */
namespace app\controllers;
use app\models\Mail;

use Yii;

class MailController extends BaseController {

    function actionSendmail () {
        $request = Yii::$app->request;
        $mailModel = new Mail();
        $recipientsAddress = $request->post('recipientsAddress');
        $subject = $request->post('subject');
        $body = $request->post('body');
        return $mailModel->sendMail($recipientsAddress, $subject, $body);
    }
}