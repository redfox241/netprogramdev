<?php
/***************************************************************************
 * 
 * Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file client.php
 * @author redfox241@sohu.com
 * @date 2014/01/19 13:57:04
 * @brief 
 *  
 **/

// Client
// 设置错误处理
error_reporting(E_ALL);
// 设置处理时间
set_time_limit(0);
 
$ip= "10.48.51.31"; // IP 地址
$port= 8080; // 端口号
 
$socket= socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // 创建一个SOCKET
if($socket)
    echo"socket_create() successed!\n";
else
    echo"socket_create() failed:".socket_strerror($socket)."\n";
 
$conn= socket_connect($socket, $ip, $port); // 建立SOCKET的连接
if($conn)
    echo"Success to connection![".$ip.":".$port."]\n";
else
    echo"socket_connect() failed:".socket_strerror($conn)."\n";
 
echo socket_read($socket, 1024);
 
$stdin= fopen('php://stdin', 'r');
while(true) {
    $command= trim(fgets($stdin, 1024));
    socket_write($socket, $command, strlen($command));
    $msg= trim(socket_read($socket, 1024));
    echo$msg."\n";
    if($msg== "Bye-Bye")
        break;
}
fclose($stdin);
socket_close($socket);

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
