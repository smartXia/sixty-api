<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/8/8
 * Time: 下午5:48
 */

namespace app\mail;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

class MailUtil {
    // Server settings(邮件服务器设置)
    public $SMTPDebug = 2;
    public $host = '';
    public $SMTPAuth = true;
    public $fromMailAddress = '';
    public $fromMailPass = '';
    public $charSet = 'UTF-8';
    public $SMTPSecure = 'ssl';
    public $port = 465;

    // Sender(发件人)
    public $senderName = '';

    // Recipients(收件人)
    public $recipientsAddress = '';
    public $recipientsName = '';

    // Responder(回复者)
    public $responderAddress = '';
    public $responderName = '';

    // Cc(抄送人)
    public $CcAddress = '';
    public $CcName = '';

    // Secret copy(秘密抄送人)
    public $secretCcAddress = '';
    public $secretCcName = '';

    // Attachments(附件)
    public $attachmentsPath = '';
    public $attachmentsName = '';

    // Content(内容)
    public $subject = '';
    public $body = '';

    function __construct(){}

    function send () {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            // $mail->SMTPDebug = $this->SMTPDebug;      // Enable verbose debug output(启用详细调试输出)
            $mail->isSMTP();                          // Set mailer to use SMTP(使用SMTP服务)
            $mail->Host = $this->host;                // Specify main and backup SMTP servers(指定主要和备用SMTP服务器)
            $mail->SMTPAuth = $this->SMTPAuth;        // Enable SMTP authentication(启用S​​MTP身份验证)
            $mail->Username = $this->fromMailAddress; // SMTP username(发件人邮箱)
            $mail->Password = $this->fromMailPass;    // SMTP username(发件人密码)
            $mail->CharSet = $this->charSet;          // Set charSet(设置邮件的字符编码，这很重要，不然中文乱码)
            $mail->SMTPSecure = $this->SMTPSecure;          // Enable TLS encryption, `ssl` also accepted(启用TLS加密，`ssl`也被接受)
            $mail->Port = $this->port;                         // TCP port to connect to(要连接的TCP端口) 常用邮箱的 SMTP 地址和端口参见：https://blog.wpjam.com/m/gmail-qmail-163mail-imap-smtp-pop3/

            // Recipients(收件人)
            $mail->setFrom($this->fromMailAddress, $this->senderName);           // 设置发件人信息，如邮件格式说明中的发件人，这里会显示为Mailer(xxxx@163.com），Mailer是当做名字显示
            $mail->addAddress($this->recipientsAddress, $this->recipientsName);  // 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@163.com)
            // $mail->addReplyTo($this->responderAddress, $this->responderName);    // 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
            $mail->addCC($this->CcAddress, $this->CcName);                       // 设置邮件抄送人，可以只写地址，上述的设置也可以只写地址
            // $mail->addBCC($this->secretCcAddress, $this->secretCcName);          // 设置秘密抄送人

            // Attachments(附件)
            // $mail->addAttachment($this->attachmentsPath, $this->attachmentsName); // 上传附件，第二参数为name，可以不传

            // Content(内容)
            $mail->isHTML(true);       // Set email format to HTML
            $mail->Subject = $this->subject;  // 邮件标题
            $mail->Body = $this->body;        // 邮件正文,可以写html，如： 'This is the html body <b>very stronge非常强壮</b>'
            //$mail->AltBody = "";            // 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用
            $mail->send();
        } catch (Exception $e) {
            var_dump($mail->ErrorInfo);
        }
    }
}