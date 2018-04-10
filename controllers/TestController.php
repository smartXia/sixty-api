<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/9/6
 * Time: 下午9:37
 */
namespace app\controllers;

use Qiniu\Auth;
//引入上传类
use Qiniu\Storage\UploadManager;

class TestController extends ComBaseController{
    function actionIndex () {
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = '2VAFPwD3YKMSBW6u1yveyQdsnFXlG3DpOqvYjAhW';
        $secretKey = 'HG9xVuLqzFpOAJkyIgY3IBRLfGMKIOIO0Xb9E7Li';
        $bucket = 'hivue';

        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);

        // 要上传文件的本地路径
        $filePath = 'images/videos/201709041142500.png';

        // 上传到七牛后保存的文件名
        $key = '201709041142500.png';

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        echo "\n====> putFile result: \n";
        if ($err !== null) {
            var_dump($err);
        } else {
            var_dump($ret);
        }
        return "test";
    }
}