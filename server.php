<?php
/***************************************************************************
 * 
 * Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/



/**
 * @file server.php
 * @author zhaochuanyong(com@baidu.com)
 * @date 2014/01/19 13:55:57
 * @brief 
 *  
 **/

// Server
// 设置错误处理
error_reporting(E_ALL);
// 设置运行时间
set_time_limit(0);
// 起用缓冲
ob_implicit_flush();
$ip= "10.48.51.31"; // IP地址
$port= 8080; // 端口号

$socket= socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // 创建一个SOCKET
if($socket)
    echo"socket_create() successed!\n";
else
    echo"socket_create() failed:".socket_strerror($socket)."\n";

$bind= socket_bind($socket, $ip, $port); // 绑定一个SOCKET
if($bind)
    echo"socket_bind() successed!\n";
else
    echo"socket_bind() failed:".socket_strerror($bind)."\n";

$listen= socket_listen($socket); // 间听SOCKET
if($listen)
    echo"socket_listen() successed!\n";
else
    echo"socket_listen() failed:".socket_strerror($listen)."\n";

while(true) {
    $msg= socket_accept($socket); // 接受一个SOCKET
    if(!$msg) {
        echo"socket_accept() failed:".socket_strerror($msg)."\n";
        break;
    }
    $welcome= "Welcome to PHP Server!\n";
    socket_write($msg, $welcome, strlen($welcome));
    while(true) {
        $command= strtoupper(trim(socket_read($msg, 1024)));
        echo $command."\n";
        if(!$command)
            break;
        switch( strtoupper($command) ) {
        case"HELLO":
            $writer= "Hello Everybody!";
            continue;
        case"QUIT":
            $writer= "Bye-Bye";
            continue;
        case"HELP":
            $writer= "HELLO\tQUIT\tHELP";
            continue;
        default:
            $writer= "Error Command!";
        }
        socket_write($msg, $writer, strlen($writer));
        if($command== "QUIT")
            break;
    }
    socket_close($msg);
}
socket_close($socket); // 关闭SOCKET




/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
