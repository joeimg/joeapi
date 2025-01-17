<?php

session_start();
require_once './config.php';
// 检查是登录还是注册请求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // 处理注册请求
        $reg_user = $_POST['username'];
        $reg_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
 
        // 检查用户名是否已存在
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $reg_user);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            echo "用户名已存在";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $reg_user, $reg_pass);
            if ($stmt->execute() === TRUE) {
                echo "注册成功";
            } else {
                echo "注册失败: " . $stmt->error;
            }
        }
 
        $stmt->close();
    } elseif (isset($_POST['login'])) {
        // 处理登录请求
        $login_user = $_POST['username'];
        $login_pass = $_POST['password'];
 
        $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
        $stmt->bind_param("s", $login_user);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
 
        if ($stmt->num_rows == 1 && password_verify($login_pass, $hashed_password)) {
            // 密码验证成功
            $_SESSION['username'] = $login_user;
            echo "登录成功";
            // 可以重定向到用户主页或其他页面
            header("Location: ../index.php");
            exit();
        } else {
            echo "
            <script>
              alert('账号密码错误。');
              window.history.back();;
            </script>";

       
        }
 
        $stmt->close();
    }
}
 
$conn->close();
?>