<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/8/9
 * Time: 上午12:26
 */
namespace app\models;

use app\mail\MailUtil;
use yii\base\Model;

class Mail extends Model {
    public $imageFile;

    /**
     * @param string $recipientsAddress 表示收件人地址
     * @param string $subject 表示邮件标题
     * @param string $body 表示邮件正文
     */
    public function sendMail($recipientsAddress, $subject = "", $body = "") {
        $mail = new MailUtil();
        $mail->host = 'smtp.163.com';
        $mail->fromMailAddress = 'sixtyden@163.com';
        $mail->fromMailPass = 'liulin60';
        $mail->CcAddress = 'sixtyden@163.com'; // 抄送人邮箱
        $mail->recipientsAddress = $recipientsAddress; // 收件人邮箱
        $mail->subject = $subject; // 邮件标题
        $mail->body = $body;  // 邮件内容
        $result = $mail->send();
        var_dump($result);
    }
}