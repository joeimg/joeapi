<?php
session_start();

if (!isset($_SESSION['username'])) {

  // 如果程序未安装，跳转到安装页面
  $relativePath = './login.html';
  // 输出JavaScript代码以跳转到相对路径指定的页面
  echo '<script>window.location.href="' . $relativePath . '";</script>';
  exit();
}

require_once '../config/config.php';

// 获取总记录数  
$totalQuery = "SELECT COUNT(*) as total FROM image_sort";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];


// 每页显示的行数
$rowsPerPage = 5;



$yeshu = ceil($totalRecords / $rowsPerPage);


// 获取当前页数
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// 计算起始行
$start = ($page - 1) * $rowsPerPage;

// 查询语句，这里以查询用户为例
$query = "SELECT * FROM image_sort ORDER BY id DESC LIMIT $start, $rowsPerPage ";

// 执行查询
$result = $conn->query($query);

// 分页逻辑
$totalRows = $conn->query("SELECT COUNT(*) FROM image_sort")->fetch_row()[0];
$totalPages = ceil($totalRows / $rowsPerPage);

// 上一页和下一页的链接
$prevPage = $page - 1 < 1 ? 1 : $page - 1;
$nextPage = $page + 1 > $totalPages ? $totalPages : $page + 1;

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>接口管理系统</title>

  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.css" rel="stylesheet">

  <!-- Add custom CSS here -->
  <link href="../css/admin.css" rel="stylesheet">
  <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
  <!-- Page Specific CSS -->
  <link rel="stylesheet" href="../css/morris-0.4.3.min.css">

</head>

<body>

  <div id="wrapper">

    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../index.php">接口管理系统</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
          <li class="">
            <a href="../index.php">
              <div class="dhdiv">
                <div class="dhtb">
                  <svg t="1736939407128" class="icon" viewBox="0 0 1024 1024" version="1.1"
                    xmlns="http://www.w3.org/2000/svg" p-id="4358" width="15" height="15">
                    <path
                      d="M126.11509 376.603271h120.028123c35.913711 0 65.025993 30.5111 65.025993 68.150756v313.758124c0 37.639656-29.112282 68.150756-65.025993 68.150756H126.11509c-35.913711 0-65.025993-30.5111-65.025992-68.150756V444.754027c0-37.639656 29.112282-68.150756 65.025992-68.150756zM444.908559 32.704656h120.028123c35.913711 0 65.025993 30.5111 65.025993 68.150757v657.656069c0 37.639656-29.112282 68.150756-65.025993 68.150756H444.908559c-35.913711 0-65.025993-30.5111-65.025992-68.150756V100.855413c0-37.638987 29.112282-68.150756 65.025992-68.150757z m324.327867 198.553283h120.028123c35.913711 0 65.025993 30.509762 65.025992 68.150756v459.103456c0 37.639656-29.112282 68.150756-65.025992 68.150756H769.236426c-35.913711 0-65.025993-30.5111-65.025993-68.150756V299.408695c0-37.640325 29.112282-68.150756 65.025993-68.150756zM63.513449 894.813663h910.37393c11.042036 0 25.598177 31.09645 25.598177 49.914606 0 18.817487-14.556141 52.08943-25.598177 52.089431H63.513449c-24.877695 0-39.433836-33.271275-39.433836-52.089431 0-18.817487 14.556141-49.914606 32.516006-49.914606h6.91783z m-6.91783 0"
                      p-id="4359" fill="#ffffff"></path>
                  </svg>

                </div>

                <div>
                  仪表盘
                </div>
              </div>

            </a>
          </li>


          <li class="active">
            <a href="./image_sort.php">
              <div class="dhdiv">
                <div class="dhtb">
                  <svg t="1736940744230" class="icon" viewBox="0 0 1024 1024" version="1.1"
                    xmlns="http://www.w3.org/2000/svg" p-id="1503" width="15" height="15">
                    <path
                      d="M562.005333 740.864V529.578667l167.936-96.938667c16.384-9.386667 21.845333-30.378667 12.458667-46.592a33.928533 33.928533 0 0 0-46.592-12.458667l-185.002667 106.837334c-10.581333 6.144-17.066667 17.408-17.066666 29.525333v230.912c0 18.773333 15.36 34.133333 34.133333 34.133333s34.133333-15.36 34.133333-34.133333z"
                      fill="#ffffff" p-id="1504"></path>
                    <path
                      d="M887.808 254.634667L577.365333 75.434667a99.293867 99.293867 0 0 0-99.328 0l-181.589333 104.96c-16.384 9.386667-21.845333 30.378667-12.458667 46.592 9.386667 16.384 30.208 21.845333 46.592 12.458666l181.589334-104.96c9.557333-5.461333 21.504-5.461333 31.061333 0l310.272 179.2c9.557333 5.461333 15.530667 15.872 15.530667 26.794667v358.229333c0 11.093333-5.973333 21.333333-15.530667 26.794667l-310.272 179.2c-9.557333 5.461333-21.504 5.461333-31.061333 0l-310.272-179.2c-9.557333-5.461333-15.530667-15.872-15.530667-26.965333V353.28l66.730667 38.058667c37.205333 21.162667 74.410667 42.325333 117.589333 67.413333 16.384 9.386667 37.205333 3.754667 46.592-12.458667 9.386667-16.384 3.754667-37.205333-12.458667-46.592-43.349333-25.088-80.725333-46.250667-117.930666-67.584-37.205333-21.162667-74.410667-42.325333-117.589334-67.413333-10.581333-6.144-23.552-6.144-34.133333 0s-17.066667 17.408-17.066667 29.525333v404.821334c0 35.328 18.944 68.266667 49.664 86.016l310.272 179.2c15.36 8.874667 32.426667 13.312 49.664 13.312a98.986667 98.986667 0 0 0 49.664-13.312L887.637333 785.066667a99.908267 99.908267 0 0 0 49.664-86.016v-358.4c0.170667-35.328-18.944-68.266667-49.493333-86.016z"
                      fill="#ffffff" p-id="1505"></path>
                  </svg>

                </div>

                <div>
                  图片分类API管理
                </div>
              </div>

            </a>
          </li>

          <li class="">
            <a href="./image.php">
              <div class="dhdiv">
                <div class="dhtb">
                  <svg t="1736940831506" class="icon" viewBox="0 0 1229 1024" version="1.1"
                    xmlns="http://www.w3.org/2000/svg" p-id="2669" width="15" height="15">
                    <path
                      d="M1106.169237 0.02048 82.701706 0.02048C25.973241 0.02048 0.01536 53.062619 0.01536 109.381492L0.01536 929.48669C0.01536 985.447171 26.02444 1024 82.701706 1024L1106.169237 1024C1162.897702 1024 1228.790784 985.805564 1228.790784 929.48669L1228.790784 109.381492C1228.790784 53.421012 1162.846503 0.02048 1106.169237 0.02048L1106.169237 0.02048 1106.169237 0.02048 1106.169237 0.02048ZM1126.223876 444.919102 1050.910182 402.98714C979.846003 363.461531 883.540729 380.305994 830.703386 441.437571L642.239955 659.545209C620.582788 684.530309 575.271695 693.541329 545.525089 678.744825L428.893822 620.633987C356.242475 584.436311 260.961181 606.963861 212.424552 671.935361L102.397952 819.183616 102.602748 102.858743 1126.326273 102.397952 1126.223876 444.919102 1126.223876 444.919102 1126.223876 444.919102ZM1126.751225 921.602048 153.612288 921.602048 294.972661 724.089055C313.865083 697.160431 355.336253 690.660419 383.751685 705.736075L500.382952 767.731999C571.959121 805.748877 667.957201 785.37489 720.231355 720.866361L908.694786 488.176827C929.737565 462.231398 972.898302 452.180958 1001.620928 469.27763L1126.853623 539.739953 1126.751225 921.602048 1126.751225 921.602048 1126.751225 921.602048ZM338.445711 519.439211C423.282414 519.439211 492.042639 450.678986 492.042639 365.842283 492.042639 281.00558 423.282414 212.245355 338.445711 212.245355 253.609008 212.245355 184.848783 281.00558 184.848783 365.842283 184.848783 450.678986 253.609008 519.439211 338.445711 519.439211L338.445711 519.439211 338.445711 519.439211ZM338.445711 314.643307C366.707546 314.643307 389.644687 337.580448 389.644687 365.842283 389.644687 394.104118 366.707546 417.041259 338.445711 417.041259 310.183876 417.041259 287.246735 394.104118 287.246735 365.842283 287.246735 337.580448 310.183876 314.643307 338.445711 314.643307L338.445711 314.643307 338.445711 314.643307Z"
                      fill="#ffffff" p-id="2670"></path>
                  </svg>

                </div>

                <div>
                  图片API管理
                </div>
              </div>

            </a>
          </li>

        </ul>

        <ul class="nav navbar-nav navbar-right navbar-user">
          <li class="dropdown user-dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target="#exampleModal"><i
                class="fa fa-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#" data-toggle="modal" data-target="#exampleModals2"><i class="fa fa-user"></i> 修改用户名</a>
              </li>
              <li><a href="#" data-toggle="modal" data-target="#exampleModals1"><i class="fa fa-lock"></i> 修改密码</a></li>
              <li class="divider"></li>
              <li><a href="../config/exit.php"><i class="fa fa-power-off"></i> 退出登录</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </nav>
    <div class="modal fade" id="exampleModals1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="left">
              <h5 class="modal-title" id="exampleModalLabel">管理员密码修改</h5>
            </div>
            <div class="right">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>

          <div class="modal-body">
            <form action="../config/upass.php" method="post">
              <label for="current_password">原密码:</label>
              <input type="password" id="current_password" class="tj-button form-control" name="current_password"
                required><br><br>

              <label for="new_password">新密码:</label>
              <input type="password" id="new_password" class="tj-button form-control" name="new_password"
                required><br><br>

              <label for="confirm_new_password">确认新密码:</label>
              <input type="password" id="confirm_new_password" class="tj-button form-control"
                name="confirm_new_password" required><br><br>
              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                <button class="btn btn-primary" type="submit">修改</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModals2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="left">
              <h5 class="modal-title" id="exampleModalLabel">用户名修改</h5>
            </div>
            <div class="right">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>

          <div class="modal-body">
            <form action="../config/upuser.php" method="post">
              <label for="current_password">新用户名:</label>
              <input type="text" id="new_username" class="tj-button form-control" name="new_username" required><br><br>
              <label for="current_password">确认新用户名:</label>
              <input type="text" id="new_usernames" class="tj-button form-control" name="new_usernames"
                required><br><br>
              <div id="status"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
            <button id="submitButton" class="btn btn-primary" type="submit">修改</button>
          </div>
          </form>



        </div>
      </div>
    </div>

    <script>
      // 获取输入框元素
      const newUsernameInput = document.getElementById('new_username');
      const confirmUsernameInput = document.getElementById('new_usernames');
      const statusDiv = document.getElementById('status');
      const submitButton = document.getElementById('submitButton');
      // 为输入框添加输入事件监听
      newUsernameInput.addEventListener('input', checkUsernames);
      confirmUsernameInput.addEventListener('input', checkUsernames);

      function checkUsernames() {
        const newUsername = newUsernameInput.value;
        const confirmUsername = confirmUsernameInput.value;
        if (newUsername === confirmUsername) {
          statusDiv.textContent = '新用户名与确认新用户名相同';
          submitButton.disabled = false; // 启用按钮
          statusDiv.style.color = 'green';
        } else {
          statusDiv.textContent = '新用户名与确认新用户名不同，请重新输入';
          submitButton.disabled = true; // 禁用按钮
          statusDiv.style.color = 'red';
        }
      }
    </script>
    <div id="page-wrapper">

      <div class="row">
        <div class="col-lg-12">
          <h1>图片分类管理 <small></small></h1>
          <ol class="breadcrumb">
            <li><a href="../index.php" style="color:#999999;"> 后台管理</a></li>
            <li><a href="#">图片分类API管理</a></li>
          </ol>


          <script>
            function insert_img_sort() {
              var form = document.getElementById('forms').value;//无须改动

              var sort_name = document.getElementById('sort_name').value;
              var priority = document.getElementById('priority').value;

              var insert = "insert_img_sort";//看需求改动和提交到另一边的operate一致用于判断使用哪个方法。


              var xhr = new XMLHttpRequest();

              xhr.open('POST', '../config/update.php', true);
              xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
              xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                  var response = JSON.parse(xhr.responseText);
                  if (response.success) {
                    location.reload(true); // 强制从服务器重新加载页面

                  } else {
                    alert('添加失败，当前分类名可能已经存在。' + response.message);
                  }
                }
              };




              var data =
                '&form=' + encodeURIComponent(form) +//无须改动
                '&operate=' + encodeURIComponent(insert) +//无须改动

                '&sort_name=' + encodeURIComponent(sort_name) +
                '&priority=' + encodeURIComponent(priority)


              xhr.send(data);
            }

          </script>
          <div class="alert alert-info alert-dismissable">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModals">
              添加分类
            </button>

            <div class="modal fade" id="exampleModals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="left">
                      <h5 class="modal-title" id="exampleModalLabel">添加分类</h5>
                    </div>
                    <div class="right">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </div>

                  <form onsubmit="event.preventDefault();insert_img_sort();">
                    <div class="modal-body" style="place-items: center;">
                      <input type="hidden" id="forms" value="insert_img_sort"> <!-- 无须改动id和typec -->
                      <input class="tj-button form-control" style="width: 80%;" type="text" id="sort_name"
                        placeholder="分类名称" required>
                      <input class="tj-button form-control" style="width: 80%; margin-top: 10px;" type="text"
                        id="priority" placeholder="优先级" required>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                      <button class="btn btn-primary" type="submit">添加</button>
                    </div>

                  </form>

                </div>
              </div>
            </div>



          </div>
        </div>
      </div><!-- /.row -->

      <div class="row">

        <div class="col-lg-12">
          <!-- <h2>视频列表</h2> -->
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="dhdiv">
                <div class="dhtb">
                  <svg t="1736940744230" class="icon" viewBox="0 0 1024 1024" version="1.1"
                    xmlns="http://www.w3.org/2000/svg" p-id="1503" width="15" height="15">
                    <path
                      d="M562.005333 740.864V529.578667l167.936-96.938667c16.384-9.386667 21.845333-30.378667 12.458667-46.592a33.928533 33.928533 0 0 0-46.592-12.458667l-185.002667 106.837334c-10.581333 6.144-17.066667 17.408-17.066666 29.525333v230.912c0 18.773333 15.36 34.133333 34.133333 34.133333s34.133333-15.36 34.133333-34.133333z"
                      fill="#ffffff" p-id="1504"></path>
                    <path
                      d="M887.808 254.634667L577.365333 75.434667a99.293867 99.293867 0 0 0-99.328 0l-181.589333 104.96c-16.384 9.386667-21.845333 30.378667-12.458667 46.592 9.386667 16.384 30.208 21.845333 46.592 12.458666l181.589334-104.96c9.557333-5.461333 21.504-5.461333 31.061333 0l310.272 179.2c9.557333 5.461333 15.530667 15.872 15.530667 26.794667v358.229333c0 11.093333-5.973333 21.333333-15.530667 26.794667l-310.272 179.2c-9.557333 5.461333-21.504 5.461333-31.061333 0l-310.272-179.2c-9.557333-5.461333-15.530667-15.872-15.530667-26.965333V353.28l66.730667 38.058667c37.205333 21.162667 74.410667 42.325333 117.589333 67.413333 16.384 9.386667 37.205333 3.754667 46.592-12.458667 9.386667-16.384 3.754667-37.205333-12.458667-46.592-43.349333-25.088-80.725333-46.250667-117.930666-67.584-37.205333-21.162667-74.410667-42.325333-117.589334-67.413333-10.581333-6.144-23.552-6.144-34.133333 0s-17.066667 17.408-17.066667 29.525333v404.821334c0 35.328 18.944 68.266667 49.664 86.016l310.272 179.2c15.36 8.874667 32.426667 13.312 49.664 13.312a98.986667 98.986667 0 0 0 49.664-13.312L887.637333 785.066667a99.908267 99.908267 0 0 0 49.664-86.016v-358.4c0.170667-35.328-18.944-68.266667-49.493333-86.016z"
                      fill="#ffffff" p-id="1505"></path>
                  </svg>

                </div>

                <div>
                  图片分类列表
                  <span class="cg" style="color: rgb(0, 255, 0);margin-left: 10px;"></span>
                </div>
              </div>

            </div>
            <div class="panel-body">

              <div class="table_tbody_box">
                <div class="videodatabox1" id="myContainer">
                  <table>
                    <thead>
                      <tr>
                        <th>序号</th>
                        <th>分类名称</th>
                        <th>优先级</th>
                        <th class="sticky-td">操作</th>

                      </tr>
                    </thead>
                    <tbody>

                      <?php while ($row = $result->fetch_assoc()): ?>

                        <script>

                          function showAlertsx(message) {
                            // 创建一个提示框元素
                            var alertBox = document.createElement('div');
                            alertBox.textContent = message;
                            alertBox.style.position = 'fixed';
                            alertBox.style.top = '20px';
                            alertBox.style.left = '50%';
                            alertBox.style.transform = 'translateX(-50%)';
                            alertBox.style.backgroundColor = '#a8f6ac';
                            alertBox.style.color = '#359a39';
                            alertBox.style.padding = '10px 20px';
                            alertBox.style.border = '1px solid #4CAF50';
                            alertBox.style.borderRadius = '5px';
                            alertBox.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                            alertBox.style.zIndex = '99999999';

                            // 初始透明度为0
                            alertBox.style.opacity = '0';
                            alertBox.style.transition = 'opacity 1s';  // 设置透明度变化的过渡时间

                            // 添加到文档中
                            document.body.appendChild(alertBox);

                            // 使提示框缓慢出现
                            setTimeout(function () {
                              alertBox.style.opacity = '1';
                            }, 10); // 延迟让样式生效

                            // 3秒后开始缓慢消失
                            setTimeout(function () {
                              alertBox.style.opacity = '0';
                            }, 2500); // 提示框在显示2.5秒后开始消失

                            // 3秒后自动移除
                            setTimeout(function () {
                              alertBox.remove();
                            }, 3000);
                          }








                          function updatesort_<?php echo $row['id']; ?>() {
                            var form = document.getElementById('form_<?php echo $row['id']; ?>').value;
                            var id = document.getElementById('id_<?php echo $row['id']; ?>').value;//用于删除

                            var sort_name = document.getElementById('sort_name_<?php echo $row['id']; ?>').value;
                            var priority = document.getElementById('priority_<?php echo $row['id']; ?>').value;


                            var submitButton = event.submitter; //一个form表单里面有多个按钮用于判断data-button-type里面的值，用的哪个按钮来提交的表单。
                            var operate = submitButton.getAttribute('data-button-type');


                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', '../config/update.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onreadystatechange = function () {
                              if (xhr.readyState === 4 && xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {

                                  if (operate === 'update') {
                                    showAlertsx("修改成功");
                                  } else if (operate === 'delete') {
                                    location.reload(true); // 强制从服务器重新加载页面



                                  }







                                } else {
                                  alert('记录修改失败: ' + response.message);
                                }
                              }
                            };
                            var data =
                              'id=' + encodeURIComponent(id) +
                              '&form=' + encodeURIComponent(form) +

                              '&sort_name=' + encodeURIComponent(sort_name) +
                              '&priority=' + encodeURIComponent(priority) +

                              '&operate=' + encodeURIComponent(operate)
                            xhr.send(data);
                          }
                        </script>


                        <form onsubmit="event.preventDefault(); updatesort_<?php echo $row['id']; ?>();">

                          <input type="hidden" id="form_<?php echo $row['id']; ?>" value="sort_<?php echo $row['id']; ?>">
                          <input type="hidden" id="id_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>">
                          <!--用于删除 -->

                          <tr>
                            <td><span><?php echo $row['id']; ?></span></td>
                            <td><input class="jum" type="text" id="sort_name_<?php echo $row['id']; ?>" placeholder="分类名称"
                                value="<?php echo $row['name']; ?>"></td>
                            <td><input class="jum" type="text" id="priority_<?php echo $row['id']; ?>" placeholder="优先级"
                                value="<?php echo $row['priority']; ?>"></td>
                            <td class="sticky-td">

                              <div>
                                <div>
                                  <button type="submit" data-button-type="update" class="pretty-button">修改</button>
                                </div>
                                <div>
                                  <button type="submit" data-button-type="delete" class="pretty-button">删除</button>
                                </div>
                              </div>


                            </td>

                          </tr>
                        </form>




                      <?php endwhile; ?>

                    </tbody>
                  </table>
                </div>
              </div>

            </div>
            <div class="ays" style="height: 50px;">
              <a href="?page=1">首页</a>
              <a href="?page=<?php echo $prevPage; ?>">上一页</a>
              <?php echo "第 $page / $yeshu 页"; ?>
              <a href="?page=<?php echo $nextPage; ?>">下一页</a>
              <a href="?page=<?php echo $totalPages; ?>">尾页</a>
            </div>
          </div>
        </div>
      </div><!-- /.row -->

    </div><!-- /#page-wrapper -->

  </div><!-- /#wrapper -->

  <!-- JavaScript -->
  <script src="../js/jquery-1.10.2.js"></script>
  <script src="../js/bootstrap.js"></script>

  <!-- Page Specific Plugins -->
  <script src="../js/raphael-min.js"></script>
  <script src="../js/morris-0.4.3.min.js"></script>
  <script src="../js/morris/chart-data-morris.js"></script>
  <script src="../js/tablesorter/jquery.tablesorter.js"></script>
  <script src="../js/tablesorter/tables.js"></script>
  <!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->
  <script src="../js/flot/jquery.flot.js"></script>
  <script src="../js/flot/jquery.flot.tooltip.min.js"></script>
  <script src="../js/flot/jquery.flot.resize.js"></script>
  <script src="../js/flot/jquery.flot.pie.js"></script>
  <script src="../js/flot/chart-data-flot.js"></script>


</body>

</html>