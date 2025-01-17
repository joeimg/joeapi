<?php
// install.php
session_start();

// Check if the application is already installed
if (file_exists(__DIR__ . '/installed.lock')) {
    die('<div style="text-align: center; margin-top: 20px;">
    <p style="font-size: 18px; color: #4caf50;">程序安装已完成。</p>
    <a href="../" style="display: inline-block; margin-top: 10px; padding: 10px 15px; background-color: #4caf50; color: #fff; text-decoration: none; border-radius: 5px;">返回首页</a>
</div>');
}

// Helper function for environment checks
function checkEnvironment()
{
    $errors = [];

    // Check PHP version
    if (PHP_VERSION_ID < 70000) { // Requires PHP 7.4 or higher
        $errors[] = "PHP版本必须是7.0或更高版本。当前版本: " . PHP_VERSION;
    }

    // Check required extensions
    $requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'json'];
    foreach ($requiredExtensions as $ext) {
        if (!extension_loaded($ext)) {
            $errors[] = "PHP扩展 '$ext' 未启用.";
        }
    }

    // Check writable directories
    $writableDirs = ['../admin/config', 'storage', 'logs'];
    foreach ($writableDirs as $dir) {
        if (!is_writable(__DIR__ . "/$dir")) {
            $errors[] = "目录 '$dir' 不可写。";
        }
    }

    return $errors;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = $_POST['db_host'];
    $dbUser = $_POST['db_user'];
    $dbPass = $_POST['db_pass'];
    $dbName = $_POST['db_name'];

    // Attempt to connect to the database
    try {
        $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        // Create the database if not exists
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `$dbName`");

        // Run initialization SQL
        $initSql = file_get_contents(__DIR__ . '/database/init.sql');
        $pdo->exec($initSql);

        // Write config file in the desired format
        $configContent = <<<PHP
<?php
header("Access-Control-Allow-Origin: *");
// 数据库连接配置
\$host = '$dbHost';
\$user = '$dbUser';
\$password = '$dbPass';
\$database = '$dbName';

// 创建数据库连接
\$conn = new mysqli(\$host, \$user, \$password, \$database);

// 检查连接
if (\$conn->connect_error) {
    die("Connection failed: " . \$conn->connect_error);
}
PHP;

        file_put_contents(__DIR__ . '/../admin/config/config.php', $configContent);

        // Create installed lock file
        file_put_contents(__DIR__ . '/installed.lock', 'Installed: ' . date('Y-m-d H:i:s'));

        // Redirect to success page
        header('Location: install.php?success=1');
        exit;
    } catch (PDOException $e) {
        $error = '数据库链接错误，请检查链接、账号、密码、数据库名是否正确: ' . $e->getMessage();
    }
}

// Check environment
$envErrors = checkEnvironment();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>程序安装</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px 30px;
            width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        p {
            font-size: 14px;
            margin: 10px 0;
        }

        ul {
            text-align: left;
            margin: 10px 0;
            padding: 0 20px;
        }

        ul li {
            margin-bottom: 5px;
        }

        form label {
            display: block;
            margin-bottom: 10px;
            text-align: left;
            font-size: 14px;
            color: #555;
        }

        form input {
            width: calc(100% - 10px);
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        form button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            width: 100%;
        }

        form button:hover {
            background-color: #45a049;
        }

        .success {
            color: #4caf50;
        }

        .error {
            color: #f44336;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>程序安装</h1>
        <h4>建议使用PHP7.4和MySQL5.7</h4>

        <?php if (!empty($_GET['success'])): ?>
            <p class="success">安装成功！</p>
        <?php elseif (!empty($envErrors)): ?>
            <p class="error">环境检查失败：</p>
            <ul>
                <?php foreach ($envErrors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <?php if (!empty($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form method="post">
                <label>
                    数据库地址:
                    <input type="text" name="db_host" value="localhost" required>
                </label>
                <label>
                    数据库账号:
                    <input type="text" name="db_user" required>
                </label>
                <label>
                    数据库密码:
                    <input type="password" name="db_pass">
                </label>
                <label>
                    数据库名:
                    <input type="text" name="db_name" required>
                </label>
                <button type="submit">安装</button>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>