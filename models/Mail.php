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
     * @param string $parent_email 表示抄送人地址
     * @param string $reply_email 表示收件人地址
     * @param string $subject 表示邮件标题
     * @param string $body 表示邮件正文
     * @param string $article_id 文章id
     */
    public function sendMail($parent_email, $reply_email, $subject = "", $body = "", $article_id) {
        $mail_template = "
            <p>$body</p>
            </br>
            </br>
            ----
            </br>
            <p>你接收到该邮件是因为你为了收到回复提醒，在Sixtyden上填写了邮箱。</p>
            <p>你可以在<a href='http://www.sixtyden.com/blog/articleDetail/$article_id'>Sixty'den</a>查看详情</p>
            <p>如果你不想收到该邮件，请联系管理员，邮箱：hiliulin@aliyun.com</p>";
        $mail = new MailUtil();
        $mail->host = 'smtp.163.com';
        $mail->fromMailAddress = 'sixtyden@163.com'; // 请换成你的
        $mail->fromMailPass = ''; // 请换成你的
        $mail->senderName = 'sixtyden';
        if ($reply_email || $parent_email) {
            if (filter_var($reply_email, FILTER_VALIDATE_EMAIL)) {
                $mail->recipientsAddress = $reply_email; // 收件人邮箱
                $mail->CcAddress = filter_var($parent_email, FILTER_VALIDATE_EMAIL) ? $parent_email : ''; // 抄送人邮箱
            } else {
                if (filter_var($parent_email, FILTER_VALIDATE_EMAIL)) {
                    $mail->recipientsAddress = $parent_email; // 收件人邮箱
                    $mail->CcAddress = 'sixtyden@163.com'; // 抄送人邮箱
                }
            }

            $mail->subject = $subject; // 邮件标题
            $mail->body = $mail_template;  // 邮件内容
            $mail->send();
        }
    }
}