<?php
ob_start(); // 开启输出缓冲
header("Access-Control-Allow-Origin: *");

require_once '../admin/config/config.php';



// SQL查询  
$sql = "SELECT * FROM image_sort ORDER BY priority ASC";
$result = $conn->query($sql);

// 处理查询结果  
$data = array(
    "errno" => "0",
    "errmsg" => "正常",
    "consume" => "2003",
    "total" => "0",
    "data" => array(),
);

if ($result->num_rows > 0) {
    // 输出每行数据  
    while ($row = $result->fetch_assoc()) {
        $data['data'][] = $row;
    }
} else {
    $data['msg'] = "没有数据";
}

// 关闭连接  
$conn->close();

// 设置JSON响应头  
header('Content-Type: application/json');

// 编码并输出JSON  
echo json_encode($data, JSON_UNESCAPED_UNICODE);


// 设置响应头为JSON格式  
header('Content-Type: application/json');


ob_end_flush(); // 发送输出并关闭缓冲




?>