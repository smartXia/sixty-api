<?php
namespace app\functions;

use GuzzleHttp\Client;

/**
 * @doc http://guzzle-cn.readthedocs.io/zh_CN/latest/overview.html
 * Class Http
 * @package Cilibs\Admin\lib
 */
class Http{

    private $client = "";

    function __construct()
    {
        $this->client = new Client(
            ['timeout' => 10, 'verify' => false,]
        );
    }


    /**
     * post请求
     * @param $url
     * @param array $data
     * @param string $type: form_params,json,multipart
     * @param string $cookie:字符串
     * @param array $header:
     *'header' => [
     *   'User-Agent' => 'testing/1.0',
     *   'Accept'     => 'application/json',
     *   'X-Foo'      => ['Bar', 'Baz'],
     *   ]
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function httpPost($url,$data=array(), $type="form_params", $header=array(), $cookie=""){
        if(!$type){
            $type = "form_params";
        }
        $request = [
            $type=>$data
        ];
        //设置header
        if($header){
            $request['headers'] = $header;
        }
        //设置cookie
        if($cookie){
            $request['headers']["Cookie"] = $cookie;
        }
        return $this->client->request("POST", $url, $request);
    }


    /**
     * @param $url
     * @param array $header
     * @param $cookie
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function httpGet($url,$header=array(),$cookie=""){
        $request=[];
        //设置header
        if($header){
            $request['headers'] = $header;
        }
        //设置cookie
        if($cookie){
            $request['headers']["Cookie"] = $cookie;
        }
        return $this->client->request("GET",$url, $request);
    }

}