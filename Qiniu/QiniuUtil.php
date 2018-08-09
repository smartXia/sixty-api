<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/9/9
 * Time: 下午4:05
 */
namespace Qiniu;

use Qiniu\Storage\UploadManager;

class QiniuUtil {
    public $auth;
    public $bucket = 'hivue';//要上传的空间
    public $domian = 'http://lib.sixtyden.com/';//要上传的空间
    public $token;
    function __construct() {
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = '2VAFPwD3YKMSBW6u1yveyQdsnFXlG3DpOqvYjAhW';
        $secretKey = 'HG9xVuLqzFpOAJkyIgY3IBRLfGMKIOIO0Xb9E7Li';
        $this->auth = new Auth($accessKey, $secretKey); // 构建鉴权对象
        $this->token = $this->auth->uploadToken($this->bucket);
    }

    //上传视频的封面图片
    function uploadImage($imgName,$imgFilePath) {
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        //第四个参数就是上传策略数组
        /*$token = $this->auth->uploadToken($this->bucket, null, 3600, [
            "callbackUrl" => "http://101.200.52.143:8080/video/imgcallback",
            "callbackBody" => 'key = $(key)',
            "mimeLimit" => "image/jpeg;image/png"
        ]);*/
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($this->token, $imgName, $imgFilePath);
        if ($err !== null) {
            return false;
        } else {
            return true;
        }
    }

    //生成视频上传专用的token （这里生成的token是用于七牛js sdk，实现js直接上传到七牛，不经过后端）
    function getUploadToken ($userid) {
        $fileName = "video".$userid.date("Ymdhis"); //视频的文件名，暂时没有后缀
        $token = $this->auth->uploadToken($this->bucket, null, 3600,["saveKey"=>$fileName]);
        $res = new \stdClass();
        $res->uptoken = $token;
        return $res;
    }
    //上传视频
    function uploadVideo() {

    }
}