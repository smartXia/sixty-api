<?php
/**
 * Created by PhpStorm.
 * User: liulin
 * Date: 2018/8/16
 * Time: 上午10:20
 */
namespace app\functions;

/**
 * 递归删除某个目录下面的所有文件和文件夹
 * scandir($path); //遍历一个文件夹所有文件并返回数组。
 * unlink($filename); //删除文件。
 * rmdir($path); //只删除空文件夹
 * @param $path
 */
class DeleteFile {
    public static function deleteDir ($path) {
        //如果是目录则继续
        if(is_dir($path)){
            //扫描一个文件夹内的所有文件夹和文件并返回数组
            $p = scandir($path);
            foreach($p as $val) {
                //排除目录中的.和..
                if($val !="." && $val !=".."){
                    //如果是目录则递归子目录，继续操作
                    if(is_dir($path.$val)){
                        //子目录中操作删除文件夹和文件
                        deleteDir($path.$val.'/');
                        //目录清空后删除空文件夹
                        @rmdir($path.$val.'/');
                    }else{
                        //如果是文件直接删除
                        unlink($path.$val);
                    }
                }
            }
        }
    }

    /**
     * 删除指定目录的指定扩展名的文件
     * @param $path // 路径
     * @param $extension // 要删除的文件的扩展名
     * @param $recursive // 是否递归删除子目录下符合要求的文件
     * @return bool
     */
    public static function deleteFileByExtension($path, $extension, $recursive = false){
        //判断要清除的文件类型是否合格
        if(!preg_match('/^[a-zA-Z]{2,}$/', $extension)) {
            return false;
        }
        //当前路径是否为文件夹或可读的文件
        if(!is_dir($path) || !is_readable($path)) {
            return false;
        }
        //遍历当前目录下所有文件
        $all_files = scandir($path);
        foreach($all_files as $filename){
            //跳过当前目录和上一级目录
            if(in_array($filename,array(".", ".."))){
                continue;
            }
            //进入到$filename文件夹下
            $full_name = $path.'/'.$filename;
            //判断当前路径是否是一个文件夹，是则递归调用函数
            //否则判断文件类型，匹配则删除
            if ($recursive && is_dir($full_name)) {
                deleteFileByExtension($full_name, $extension, true);
            } else {
                preg_match("/(.*)\.$extension/", $filename, $match);
                if (!empty($match[0][0])) {
                    unlink($full_name);
                }
            }
        }
    }

    public static function deleteFileByName($path_name) {
        if (is_dir($path_name)) {
            return false;
        } else {
            unlink($path_name);
        }
    }
}
