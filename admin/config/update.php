<?php
require_once 'config.php'; // 确保这个文件包含了数据库连接的初始化  
// 绑定参数  

$form = $_POST['form'] ?? '';
$operate = $_POST['operate'] ?? '';
$id = (int) $_POST['id'];






if ($operate === 'update') {
    // 执行修改操作

    // 检查是否通过POST方法接收到了数据  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['form'])) {
            switch ($_POST['form']) {
                // 可以添加更多的case来处理其他表单
                case 'updatedate_' . $id:

                    $vod_name = $_POST['vod_name'] ?? '';
                    $vod_pic = $_POST['vod_pic'] ?? '';
                    $vod_url = $_POST['vod_url'] ?? '';
                    $vod_id = (int) $_POST['vod_id'];

                    $stmt = $conn->prepare("UPDATE video SET vod_name = ?, vod_pic = ?, vod_url = ?,vod_id = ? WHERE id = ?");
                    $stmt->bind_param("sssii", $vod_name, $vod_pic, $vod_url, $vod_id, $id);


                    // 执行预处理语句  
                    if ($stmt->execute() === TRUE) {
                        // 设置响应头为JSON格式  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true]);
                    } else {
                        // 设置响应头为JSON格式，并包含错误信息  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $stmt->error]);
                    }

                    // 关闭语句和连接
                    $stmt->close();
                    $conn->close();
                    break;

                case 'sort_' . $id:

                    $sort_name = $_POST['sort_name'] ?? '';
                    $priority = (int) $_POST['priority'];


                    $stmt = $conn->prepare("UPDATE image_sort SET name = ?, priority = ? WHERE id = ?");
                    $stmt->bind_param("sii", $sort_name, $priority, $id);


                    // 执行预处理语句  
                    if ($stmt->execute() === TRUE) {
                        // 设置响应头为JSON格式  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true]);
                    } else {
                        // 设置响应头为JSON格式，并包含错误信息  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $stmt->error]);
                    }

                    // 关闭语句和连接
                    $stmt->close();
                    $conn->close();
                    break;


                case 'img_' . $id:

                    $imgurl = $_POST['imgurl'] ?? '';
                    $name = $_POST['name'] ?? '';
                    $class_ids = (int) $_POST['class_ids'];


                    $stmt = $conn->prepare("UPDATE image SET class_id = ?, url = ?, name = ? WHERE id = ?");
                    $stmt->bind_param("issi", $class_ids, $imgurl,$name, $id);


                    // 执行预处理语句  
                    if ($stmt->execute() === TRUE) {
                        // 设置响应头为JSON格式  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true]);
                    } else {
                        // 设置响应头为JSON格式，并包含错误信息  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $stmt->error]);
                    }

                    // 关闭语句和连接
                    $stmt->close();
                    $conn->close();
                    break;




            }
        }
    }







} else if ($operate === 'delete') {

    if (isset($_POST['form'])) {
        switch ($_POST['form']) {
            // 可以添加更多的case来处理其他表单
            case 'updatedate_' . $id:
                // 执行删除操作

                // 准备删除的SQL语句
                $sql = "DELETE FROM video WHERE id = ?";

                // 为MySQL预处理语句绑定参数
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id); // "i" 表示参数是整数

                // 执行预处理语句  
                if ($stmt->execute() === TRUE) {
                    // 设置响应头为JSON格式  
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true]);
                } else {
                    // 设置响应头为JSON格式，并包含错误信息  
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $stmt->error]);
                }
                // 关闭语句和连接
                $stmt->close();
                $conn->close();
                break;

            case 'sort_' . $id:

                // 执行删除操作

                // 准备删除的SQL语句
                $sql = "DELETE FROM image_sort WHERE id = ?";

                // 为MySQL预处理语句绑定参数
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id); // "i" 表示参数是整数

                // 执行预处理语句  
                if ($stmt->execute() === TRUE) {
                    // 设置响应头为JSON格式  
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true]);
                } else {
                    // 设置响应头为JSON格式，并包含错误信息  
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $stmt->error]);
                }
                // 关闭语句和连接
                $stmt->close();
                $conn->close();
                break;

            case 'img_' . $id:

                // 执行删除操作

                // 准备删除的SQL语句
                $sql = "DELETE FROM image WHERE id = ?";

                // 为MySQL预处理语句绑定参数
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id); // "i" 表示参数是整数

                // 执行预处理语句  
                if ($stmt->execute() === TRUE) {
                    // 设置响应头为JSON格式  
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true]);
                } else {
                    // 设置响应头为JSON格式，并包含错误信息  
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $stmt->error]);
                }
                // 关闭语句和连接
                $stmt->close();
                $conn->close();
                break;

        }
    }



} else if ($operate === 'insert') {

    // 检查是否通过POST方法接收到了数据  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['form'])) {
            switch ($_POST['form']) {
                // 可以添加更多的case来处理其他表单
                case 'insert':

                    $vod_name = $_POST['vod_name'] ?? '';//传递过来的剧名
                    $vod_pic = $_POST['vod_pic'] ?? '';//传递过来的封面
                    $vod_url = $_POST['vod_url'] ?? '';//传递过来的观看链接
                    $vod_id = (int) $_POST['vod_id'] ?? '';


                    // 准备和绑定  
                    $stmt = $conn->prepare("INSERT INTO video (vod_name, vod_pic, vod_url,vod_id) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("sssi", $vod_name, $vod_pic, $vod_url, $vod_id);//s代表字符串，需要修改多少个字符串的参数就加多少个S，如有整数用i

                    // 执行语句  
                    if ($stmt->execute() === TRUE) {
                        // 设置响应头为JSON格式  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true]);
                    } else {
                        // 设置响应头为JSON格式，并包含错误信息  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $stmt->error]);
                    }



                    break;

            }

        }
    }
} else if ($operate === 'insert_img_sort') {

    // 检查是否通过POST方法接收到了数据  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['form'])) {
            switch ($_POST['form']) {
                // 可以添加更多的case来处理其他表单
                case 'insert_img_sort':

                    $sort_name = $_POST['sort_name'] ?? '';//传递过来的剧名
                    $priority = (int) $_POST['priority'] ?? '';


                    // 准备和绑定  
                    $stmt = $conn->prepare("INSERT INTO image_sort (name, priority) VALUES (?, ?)");
                    $stmt->bind_param("si", $sort_name, $priority);//s代表字符串，需要修改多少个字符串的参数就加多少个S，如有整数用i

                    // 执行语句  
                    if ($stmt->execute() === TRUE) {
                        // 设置响应头为JSON格式  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true]);
                    } else {
                        // 设置响应头为JSON格式，并包含错误信息  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $stmt->error]);
                    }



                    break;

            }

        }
    }
} else if ($operate === 'insert_image') {

    // 检查是否通过POST方法接收到了数据  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['form'])) {
            switch ($_POST['form']) {
                // 可以添加更多的case来处理其他表单
                case 'insert_image':

                    $image_url = $_POST['image_url'] ?? '';//传递过来的剧名
                    $image_name = $_POST['image_name'] ?? '';//传递过来的剧名
                    $class_ids = (int) $_POST['class_ids'] ?? '';


                    // 准备和绑定  
                    $stmt = $conn->prepare("INSERT INTO image (class_id, url,name) VALUES (?, ?, ?)");
                    $stmt->bind_param("iss", $class_ids, $image_url,$image_name);//s代表字符串，需要修改多少个字符串的参数就加多少个S，如有整数用i

                    // 执行语句  
                    if ($stmt->execute() === TRUE) {
                        // 设置响应头为JSON格式  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true]);
                    } else {
                        // 设置响应头为JSON格式，并包含错误信息  
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $stmt->error]);
                    }



                    break;

            }

        }
    }
}





?>