<?php
header("Access-Control-Allow-Origin: *");
// 数据库连接配置
$host = '';
$user = '';
$password = '';
$database = '';

// 创建数据库连接
$conn = new mysqli($host, $user, $password, $database);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}