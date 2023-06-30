<?php

/**
 * 功能：隐藏内网ip，起始页自动切换内外网，点击链接自动切换内外网
 * External to External：https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
 * Internal to internal：10.10.10.248/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
 * Internal and external IP address translation：../zhuan.php?lan=:1315&wan=https://homelab.demo.com:81&name=switch
 * 
 * Unraid：../zhuan.php?lan=:80&wan=https://unraid.demo.com:81&name=unraid
 * Other application：../zhuan.php?lan=13:80&wan=https://qb.demo.com:81&name=server
 */

//internal ip
$local_host = '10.10.10.';

//server and rooter ip
$unraid_ip='10.10.10.254';
$ikuai_ip='10.10.10.253';
$openwrt_ip='10.10.10.252';
$tp_ip='10.10.10.251';
$asus_ip='10.10.10.250';
$truenas_ip='10.10.10.249';
$vpnserver_ip='10.10.10.248';

//other application ip
$server_ip='10.10.10.2';

if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{

    //获取当前的域或ip
    $host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']);
    $temp = strstr ($host, ':', true);

    // if(!$_SERVER["HTTP_X_FORWARDED_FOR"]) //用来源ip或域名判断
    if(strpos($temp,$local_host) !== false) //判断当前的域或ip是否为内网ip
    {
        //url is internal
        if(isset($_GET["lan"])) //判断所需要的lan参数是否存在，isset用来检测变量是否设置，返回true or false
        {
            if(isset($_GET["name"])) {
                if($_GET["name"]=="switch") {
                    $url = $_GET["wan"]; //Internal to external
                }
                else if ($_GET["name"]=="unraid") { //判断name选择对应的ip
                    $url = "http://".$unraid_ip.$_GET["lan"];
                }
                else if ($_GET["name"]=="ikuai") {
                    $url = "http://".$ikuai_ip.$_GET["lan"];
                }
                else if ($_GET["name"]=="openwrt") {
                    $url = "http://".$openwrt_ip.$_GET["lan"];
                }
                else if ($_GET["name"]=="tplink") {
                    $url = "http://".$tp_ip.$_GET["lan"];
                }
                else if ($_GET["name"]=="asus") {
                    $url = "http://".$asus_ip.$_GET["lan"];
                }
                else if ($_GET["name"]=="truenas") {
                    $url = "http://".$truenas_ip.$_GET["lan"];
                }
                else if ($_GET["name"]=="vpnserver") {
                    $url = "http://".$vpnserver_ip.$_GET["lan"];
                }
                else if ($_GET["name"]=="server") {
                    $url = "http://".$server_ip.$_GET["lan"];
                }
                else if ($_GET["name"]=="lskypro") { 
                    $url = "http://".$unraid_ip.$_GET["lan"]; //兰空图床特殊处理（已废弃）
                }
                elseif ($_GET["name"]=="auto") {
                    $url = "http://".$vpnserver_ip.$_GET["lan"]; //已在本地内网无需跳转
                }
                else {
                    $url = "http://".$vpnserver_ip.$_GET["lan"]; //无匹配上的name，则跳回起始页
                }
            }
            else {
                $url = "http://".$_GET["lan"];  //没有name需写全内网ip，不加上http协议报403
            }
            header("Location: $url");
            exit();
        }
    }
    else
    {
        //url is external
        if(isset($_GET["wan"])) //判断所需要的wan参数是否存在
        {
            if($_GET["name"]=="switch") {
                $url = "http://".$vpnserver_ip.$_GET["lan"]; //External to Internal
                // $url = "http://".($temp?$temp:$host).":81";
            }
            else if($_GET["name"]=="lskypro") {
                $url = "http://".$_GET["wan"]; //兰空图床特殊处理（已废弃）
            }
            else if($_GET["name"]=="tplink") {
                $url = "http://".$_GET["wan"]; //TP路由器特殊处理（已废弃）
            }
            else if ($_GET["name"]=="auto") {
                if (strpos($_SERVER["HTTP_X_FORWARDED_FOR"],$local_host) !== false) { //来源ip与本地网段一致则自动跳回内网
                    $url = "http://".$vpnserver_ip.$_GET["lan"];
                }
                else {
                    $url = $_GET["wan"];
                }
            }
            else {
                $url = $_GET["wan"]; ///没有name参数默认走wan后的域名
            }
            header("Location: $url");
            exit();
        }
    }
}

//Get参数不存在，lan和wan的参数不存在输出404
header("http/1.1 404 not found");
header("status: 404 not found");
//echo 'echo 404';//直接输出页面错误信息
header('location: /404.html');
exit();
?>