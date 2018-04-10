<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2017/9/3
 * Time: 下午9:32
 */
namespace app\M;

use Qiniu\QiniuUtil;
use yii\base\Model;

class Uploader extends Model
{
    public $imageFile;

    public function rules()
    {
        return [
            //[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        //初始化成功够要返回数据
        $result = new \stdClass();
        $result->name = "";
        $result->status = 0;
        $result->url= "";
        $result->id=0;
        $userid = 0; // 用户id,默认为0，代表超级管理员

        $imgName = date('Ymdhis').$userid . '.' . $this->imageFile->extension;
        if ($this->validate()) {
            $vi = ModelFactory::loadModel("videos_img");
            $vi -> img_name = $imgName;
            $vi -> img_url = "http://ovrjw2my5.bkt.clouddn.com/" . $vi -> img_name;

            //第一步：先上传文件到真实服务器
            $upload_service = $this->imageFile->saveAs('images/videos/' . $vi -> img_name);//上传到服务器真实文件夹路径

            //第二步：如果第一步成功，将文件上传到七牛云
            if ($upload_service) {
                $qutil = new QiniuUtil();
                $img_filePath = 'images/videos/' . $vi -> img_name;//第一步保存在服务器上的图片的真实物理路径
                $upload_qiniu = $qutil -> uploadVImg($vi->img_name, $img_filePath);//上传到七牛
                if($upload_qiniu) {
                    //第三部：将第二步上传到七牛云的图片的地址更新到数据库
                    $save_img = $vi->save();
                    if ($save_img) {
                        $result -> name = $vi -> img_name;
                        $result -> url = $vi -> img_url;
                        $result->status = 1;
                        $result->id = $vi -> img_id; //这里的 img_id 是第三部save成功后自动赋值的 img_id为数据库字段名
                        //第四部：返回结果之前应该将第一步上传到服务器上的真实文件删除，以节约服务器空间，当然不删也是没问题的。

                        return json_encode($result); //成功了，返回json结果
                    } else {
                        var_dump('上传到数据库时出错');
                    }
                } else {
                    var_dump('上传到七牛时出错');
                }
            } else {
                var_dump('上传到服务器时出错');
            }
        }
        return json_encode($result);
    }
}