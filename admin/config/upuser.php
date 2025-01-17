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
$new_username = $_POST['new_username'];

// 对新用户名进行验证（比如检查是否已存在或是否符合格式要求）
// 这里假设用户名不能为空且长度在3到20个字符之间
if (empty($new_username) || !preg_match("/^[a-zA-Z0-9_]{3,20}$/", $new_username)) {
    die("用户名无效。它的长度应在3到20个字符之间，并且只能包含字母、数字和下划线。");
}

// 检查新用户名是否已存在
$stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
$stmt->bind_param("s", $new_username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("用户名已存在。");
}

// 更新用户名
$update_stmt = $conn->prepare("UPDATE users SET username = ? WHERE username = ?");
$update_stmt->bind_param("ss", $new_username, $_SESSION['username']);

if ($update_stmt->execute()) {
    session_start();
    session_unset();
    session_destroy();
    die("
    <script>
      alert('用户名修改成功，请重新登录。');
      window.history.back();;
    </script>");

    // 可以选择性地重定向到另一个页面或刷新当前页面
    // header("Location: profile.php");
    // exit();
} else {
    echo "更改用户名时出错。";
}

$update_stmt->close();
$stmt->close();
$conn->close();
?>