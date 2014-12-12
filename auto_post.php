<?php
/**
 * Created by PhpStorm.
 * Date: 2014/12/12
 * Time: 23:14
 */
require "db_mysql.php";

$uid = 1; // 用户id
$author = 'admin';//用户名
$fid = 2;//版块
$ip = '127.0.0.1'; // 用户ip
$time = time();
$view = rand(5, 60); // 阅读量
$subject = '测试主题5';//标题
$message = '测试内容6';//内容
$port = 0;
// 创建主题,获得主题tid
$insert = "INSERT INTO pre_forum_thread (fid, typeid, author, authorid, subject, dateline, lastpost, lastposter, views) VALUES ('$fid', 0, '$author', '$uid', '$subject', '$time', '$time', '$author', '$view')";
$db_mysql->query($insert);
$tid = $db_mysql->insert_id;
// post分表协调表,帖子总数自增，获得帖子pid
$insert = "INSERT INTO pre_forum_post_tableid VALUES (NULL)";
$db_mysql->query($insert);
$pid = $db_mysql->insert_id;
// 创建帖子内容
$insert = "INSERT INTO pre_forum_post (pid, fid, tid, author, authorid, subject, dateline, message, useip, port, position,usesig) VALUES ('$pid', '$fid', '$tid', '$author', '$uid', '$subject', '$time', '$message', '$ip', '$port', 1,1)";
mysql_query($insert);
// 更新版块新帖记录
$sql = "SELECT threads, posts FROM pre_forum_forum WHERE fid = '$fid'";
$result = $db_mysql->get_row($sql);
$threads = $result->threads + 1;
$posts = $result->posts + 1;
$lastpost = $tid . "\t" . $subject . "\t" . $time . "\t" . $author;
$sql = "UPDATE pre_forum_forum SET threads = '$threads', posts = '$posts', lastpost = '$lastpost' WHERE fid = '$fid'";
$db_mysql->query($sql);
