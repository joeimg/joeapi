<?php
ob_start(); // 开启输出缓冲

header("Access-Control-Allow-Origin: *");
require_once '../admin/config/config.php';
// 获取GET参数
$cid = isset($_GET['cid']) ? (int)$_GET['cid'] : 1;
$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
$count = isset($_GET['count']) ? (int)$_GET['count'] : 47; // 默认每页47条记录



// 验证cid, start, count（根据实际需求调整）
if ($cid <= 0 || $start < 0 || $count <= 0) {
    die("无效的参数");
}

// 获取总记录数
$sql_total = "SELECT COUNT(*) AS total FROM image WHERE class_id = ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("i", $cid);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total = 0;
if ($result_total->num_rows > 0) {
    $row_total = $result_total->fetch_assoc();
    $total = $row_total['total']; // 获取总记录数
}

// 构建分页查询
$sql = "SELECT * FROM image WHERE class_id = ? ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $cid, $count, $start);

// 执行查询
$stmt->execute();
$result = $stmt->get_result();

// 处理查询结果  
$data = array(
    "errno" => "0",
    "errmsg" => "正常",
    "consume" => "0",
    "total" => $total,  // 设置总记录数
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