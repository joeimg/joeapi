<?php
session_start();

// 假设您已经有一个数据库连接 $conn
// $conn = new mysqli('hostname', 'username', 'password', 'database_name');
require_once './config.php';
// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    header("Location: ../page/login.php");
    exit();
}

// 获取表单数据
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];

// 检查新密码和确认密码是否匹配
if ($new_password !== $confirm_new_password) {
    die("
    <script>
      alert('新密码和确认密码错误。');
      window.history.back();;
    </script>");
}

// 从数据库中获取用户的当前密码（这里需要您根据自己的数据库结构来修改）
// 假设有一个名为users的表，包含user_id, password等字段
$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashed_password);

if ($stmt->num_rows > 0) {
    $stmt->fetch();

    // 验证当前密码（这里使用您之前用于哈希密码的相同方法，比如password_verify）
    if (!password_verify($current_password, $hashed_password)) {
        die("
        <script>
          alert('原密码错误');
          window.history.back();;
        </script>");
   
    }

    // 更新密码（使用password_hash来哈希新密码）
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $update_stmt->bind_param("ss", $new_hashed_password, $_SESSION['username']);

    if ($update_stmt->execute()) {

        // echo "<script>alert('修改成功');</script>";
        session_start();
        session_unset();
        session_destroy();
        die("
        <script>
          alert('密码修改成功，请重新登录。');
          window.history.back();;
        </script>");
   
 


        // 可以选择性地重定向到另一个页面或刷新当前页面
        // header("Location: some_page.php");
        // exit();
    } else {
        echo "错误.";
    }

    $update_stmt->close();
} else {
    echo "未找到用户.";
}

$stmt->close();
$conn->close();
?>