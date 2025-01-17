<?php


if (file_exists(__DIR__ . '/install/installed.lock')) {
    // 如果程序已经安装，直接跳转到主页（或其他地方）


} else {

   // 如果程序未安装，跳转到安装页面
   $relativePath = './install/install.php';
   // 输出JavaScript代码以跳转到相对路径指定的页面
   echo '<script>window.location.href="' . $relativePath . '";</script>';
    exit;
}
?>


<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joe主题——壁纸模板自定义API</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.4.0/fabric.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            text-align: center;
        }

        h1 {
            font-size: 3em;
            color: #2c3e50;
            margin-bottom: 0.5em;
        }

        h2 {
            font-size: 1.5em;
            color: #16a085;

        }

        .button-s {
            background-color: #2980b9;
            color: white;
            font-size: 1em;
            padding: 12px 0px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 5px;
            width: 150px;

        }

        .button-s:hover {
            background-color: #3498db;
        }

        h3 {
            font-size: 1.5em;
            margin-top: 1.5em;
            color: #e74c3c;
        }

        .api-info {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            text-align: left;
            border-left: 5px solid #3498db;
        }


        .api-info div {
            font-size: 1em;
            margin-bottom: 10px;
            color: #7f8c8d;
        }

        .api-info .api-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #34495e;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }







        .api-infos {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            text-align: left;
            margin-top: 20px;

        }


        .api-infos div {
            font-size: 1em;
            margin-bottom: 10px;
            color: #7f8c8d;
        }

        .api-infos .api-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #34495e;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }




        .tutorial-section {
            margin: 30px 0;
            padding: 20px;
            width: 90%;
            max-width: 1000px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .tutorial-section h4 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #16a085;
            padding-bottom: 10px;
        }

        .tutorial-step {
            margin-bottom: 30px;
            text-align: center;
        }

        .tutorial-step img {
            width: 100%;
            /* max-width: 500px; */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 15px auto;
            display: block;
            cursor: pointer;
            /* 显示为手型 */
        }

        .tutorial-step .step-title {
            font-size: 1.5em;
            color: #3498db;
            margin-bottom: 10px;
        }

        .tutorial-step .step-description {
            font-size: 1em;
            line-height: 1.6em;
            color: #000000;
            text-align: center;
            /* 将描述文字居中 */
            margin-top: 10px;
        }

        /* 放大图片的样式 */
        .lightbox {
            display: none;
            /* 初始不显示 */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            overflow: visible;
            /* 允许内容超出容器 */
        }

        .lightbox img {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            cursor: move;
            /* 鼠标样式为移动 */
            user-select: none;
            /* 防止图片被选中 */
            position: absolute;
            /* 可通过 left 和 top 移动图片 */
            max-width: 100%;
            /* 让图片在手机上更好地自适应 */
            max-height: 100%;
        }

        /* 关闭按钮样式 */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.3);
            color: white;
            font-size: 2em;
            border: none;
            border-radius: 50%;
            padding: 5px 10px;
            cursor: pointer;
            z-index: 1001;
            height: 50px;
            width: 50px;
            /* background: red; */
        }

        /* 缩放按钮样式 */
        .zoom-btn {
            position: fixed;
            background-color: rgba(0, 0, 0, 0.3);
            color: white;
            border: none;
            border-radius: 50%;
            padding: 5px 10px;
            cursor: pointer;
            z-index: 1001;
            font-size: 14px;
            height: 50px;
            width: 50px;

            /* 将缩放按钮置于最顶层 */
        }

        .zoom-in-btn {
            top: 40%;
            right: 2%;
            /* right:50px; */
            /* 增加左侧间距 */
        }

        .zoom-out-btn {
            top: 60%;
            right: 2%;
            /* 增加左侧间距并下移 */
        }

        .zoom-fw-btn {
            top: 50%;
            right: 2%;
        }


        .close-btn:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }



        .zoom-btn:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .button-container {
            display: flex;
            /* 使用 flexbox 布局 */
            flex-wrap: wrap;
            /* 允许按钮换行 */
            justify-content: space-around;
            /* 按钮间距均匀分布 */

            /* 添加顶部间距 */
        }

        pre {
            display: flex;
            /* 使用 flex 布局 */
            background-color: #f4f4f4;
            /* 背景颜色 */
            border: 1px solid #ddd;
            /* 边框 */
            border-radius: 5px;
            /* 圆角 */
            margin: 20px auto;
            /* 居中 */
            width: 100%;
            /* 宽度 */
            max-height: 400px;
            /* 最大高度 */
            overflow: auto;
            /* 开启滚动条 */
            font-family: "Courier New", Courier, monospace;
            /* 等宽字体 */
            font-size: 14px;
            /* 字体大小 */
            text-align: left;
        }

        /* 行号部分 */
        pre::before {
            counter-reset: line;
            /* 重置行号计数器 */
            content: '';
            /* 清空默认内容 */
        }

        code {
            display: block;
            padding-left: 30px;
            /* 给行号留空间 */
            white-space: pre;
            /* 保留换行，不自动换行 */
            overflow-x: auto;
            /* 超出时显示滚动条 */
            position: relative;
            width: 100%;
        }

        /* 每一行代码显示行号 */
        code>span {
            /* display: block; */
            counter-increment: line;
            /* 每一行+1 */
            position: relative;
            color: red;
        }

        code>span::before {
            content: counter(line);
            /* 显示行号 */
            position: absolute;
            left: -30px;
            /* 放置在代码块左侧 */
            width: 25px;
            /* 行号区域宽度 */
            text-align: right;
            /* 行号右对齐 */
            color: #888;
            /* 行号颜色 */
        }

        @media (max-width: 768px) {
            .button-container {
                display: flex;

            }

            .button-s {
                width: 100%;
                margin-right: 20px;
                margin-left: 20px;
            }

            .button-container {
                width: 100%;

            }

            pre {
                width: 100%;
            }

            /* .close-btn {
                text-align: right;
            } */

            /* .zoom-in-btn {

                left: 60px;

            }

            .zoom-out-btn {

                right: 60px;

            } */

        }
    </style>
    <script>
        function redirectToPage() {
            // 将此处的URL替换为你想要跳转的页面的URL
            window.open('./admin', '_blank');
        }

        function openNewLink() {
            // 弹出消息框
            alert("蓝奏云链接访问密码为：123");
            // 在新窗口中打开新链接
            window.open("https://wwxy.lanzouk.com/b00y9ttyna", "_blank");
        }
    </script>
</head>

<body>

    <h1>Joe主题——壁纸模板自定义API</h1>
    <h2>独立程序，专属后台。</h2>
    <div class="button-container">
        <button class="button-s" type="button" onclick="redirectToPage()">立即登录</button>

    </div>
    <span style="font-size: 14px;color: #7f8c8d;">初始账号：admin 初始密码：admin</span>
    <div class="button-container">
        <button class="button-s" type="button"
            onclick="window.open('http://joe.033303.xyz/ty/', '_blank')">Joe主题演示站</button>
    </div>

    <div class="api-infos">
        <div class="api-title">开源地址：</div>


        <div class="button-container">
            <button class="button-s" onclick="window.open('https://github.com/joeimg/joeapi', '_blank')">GitHub</button>
            <button class="button-s" onclick="window.open('https://gitee.com/joeimg/joeapi', '_blank')">Gitee</button>
            <button class="button-s" onclick="openNewLink()">蓝奏云</button>


        </div>
    </div>

    <h3>您的专属API</h3>

    <div class="api-info">
        <div class="api-title">图片分类API：</div>
        <div id="protocol-domain" class="api-url"></div>
    </div>

    <div class="api-info">
        <div class="api-title">图片API：</div>
        <div id="protocol-domains" class="api-url"></div>
    </div>

    <div class="tutorial-section">
        <h4>效果预览图</h4>

        <div class="tutorial-step">
            <img src="./image/18.png" alt="步骤1图片" class="clickable-image">
        </div>
    </div>
    <!-- 使用教程部分 -->
    <div class="tutorial-section">
        <h4>使用教程</h4>

        <div class="tutorial-step">
            <div class="step-title">修改Joe主题文件来使用自定义图片api</div>
            <div class="step-description">
                1、拿到你的专属api
            </div>
            <img src="./image/1.png" alt="步骤1图片" class="clickable-image">
            <div class="step-description">
                2、打开joe主题文件joe-master → core → route.php文件，找到里面对应的图片分类api和图片api，joe作者已添加了注释。如下图。
            </div>
            <img src="./image/2.png" alt="步骤2图片" class="clickable-image">
            <div class="step-description">
                3、将您的专属api分别对应替换进去，图片分类API替换到壁纸分类里面，图片API替换到壁纸列表里面。替换后如下图。
            </div>
            <img src="./image/3.png" alt="步骤3图片" class="clickable-image">
        </div>
        <hr>
        <div class="tutorial-step">
            <div class="step-title">开启Joe主题的壁纸模板</div>
            <div class="step-description">
                1、登录您的typecho后台点击管理 → 独立页面。如下图。
            </div>
            <img src="./image/4.png" alt="步骤1图片" class="clickable-image">
            <div class="step-description">
                2、点击新增如。如下图。
            </div>
            <img src="./image/5.png" alt="步骤2图片" class="clickable-image">
            <div class="step-description">
                3、填写页面名称，页面文件名，右侧自定义模板选择壁纸。如下图。
            </div>
            <img src="./image/6.png" alt="步骤3图片" class="clickable-image">
            <div class="step-description">
                4、最后发布页面
            </div>
            <img src="./image/20.png" alt="步骤4图片" class="clickable-image">

            <div class="step-description">
                5、发布后的效果
            </div>
            <img src="./image/7.png" alt="步骤4图片" class="clickable-image">
            <img src="./image/8.png" alt="步骤5图片" class="clickable-image">
        </div>

        <hr>

        <div class="tutorial-step">
            <div class="step-title">修复壁纸模板翻页功能</div>
            <div class="step-description">
                使用自定义壁纸api后会发现原来的翻页功能是有BUG的，就是两张图片也能一直往后翻页的。
            </div>
            <img src="./image/14.png" alt="步骤1图片" class="clickable-image">
            <div class="step-description">
                1、打开joe主题文件joe-master → wallpaper.php文件，将里面的joe.wallpaper.min.js修改成joe.wallpaper.js。如下图
            </div>
            <div class="step-description">
                修改前
            </div>
            <img src="./image/9.png" alt="步骤1图片" class="clickable-image">
            <div class="step-description">
                修改后
            </div>
            <img src="./image/10.png" alt="步骤2图片" class="clickable-image">
            <div class="step-description">
                2、打开joe主题文件joe-master → assets → js → joe.wallpaper.js文件，找到function
                initPagination()方法，57行到79行，下图框选的代码进行替换。
            </div>
            <img src="./image/11.png" alt="步骤3图片" class="clickable-image">
            <div class="step-description">
                3、将下面1到28行的代码替换进去。
            </div>


            <!-- 显示代码块 -->
            <pre>
                <code>
<span>function initPagination() {</span>
<span>    let htmlStr = '';</span>
<span>    const totalPages = Math.ceil(total / queryData.count);</span>
<span>    const currentPage = Math.ceil(queryData.start / queryData.count) + 1;</span>
<span>    if (queryData.start / queryData.count!== 0) {</span>
<span>        htmlStr += `</span>
<span>             &lt;li class="joe_wallpaper__pagination-item" data-start="0"&gt;首页&lt;/li&gt; </span>
<span>             &lt;li class="joe_wallpaper__pagination-item" data-start="${queryData.start - queryData.count}"&gt;</span>
<span>                 &lt;svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="12" height="12"&gt;&lt;path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z"/&gt;&lt;path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312.512zm-564.224-63.488c0-3.584 0-7.68.512-11.264h-.512v-714.24h.512c-.512-3.584-.512-7.168-.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-.512 11.264h.512v714.24h-.512c.512 3.584.512 7.168.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"/&gt;&lt;/svg&gt;</span>
<span>             &lt;/li&gt;</span>
<span>             &lt;li class="joe_wallpaper__pagination-item" data-start="${queryData.start - queryData.count}"&gt;${currentPage - 1}&lt;/li&gt;</span>
<span>        `;</span>
<span>    }</span>
<span>    htmlStr += `&lt;li class="joe_wallpaper__pagination-item active"&gt;${currentPage}&lt;/li&gt;`;</span>
<span>    if (currentPage < totalPages) {</span>
<span>        htmlStr += `</span>
<span>          &lt;li class="joe_wallpaper__pagination-item" data-start="${queryData.start + queryData.count}"&gt;${currentPage + 1}&lt;/li&gt;</span>
<span>          &lt;li class="joe_wallpaper__pagination-item" data-start="${queryData.start + queryData.count}"&gt;</span>
<span>              &lt;svg class="next" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="12" height="12"&gt;&lt;path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z"/&gt;&lt;path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312.512zm-564.224-63.488c0-3.584 0-7.68.512-11.264h-.512v-714.24h.512c-.512-3.584-.512-7.168-.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-.512 11.264h.512v714.24h-.512c.512 3.584.512 7.168.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"/&gt;&lt;/svg&gt;</span>
<span>          &lt;/li&gt;</span>
<span>        `;</span>
<span>    }</span>
<span>    if (queryData.start < total - queryData.count) {</span>
<span>        const lastPageStart = total % queryData.count === 0 ? total - queryData.count : total - (total % queryData.count);</span>
<span>        htmlStr += `&lt;li class="joe_wallpaper__pagination-item" data-start="${lastPageStart}"&gt;末页&lt;/li&gt;`;</span>
<span>    }</span>
<span>    $('.joe_wallpaper__pagination').html(htmlStr);</span>
<span>}</span>
<span></span>
<span></span>

                </code>
            </pre>
            <div class="step-description">
                替换后
            </div>
            <img src="./image/12.png" alt="步骤4图片" class="clickable-image">
            <div class="step-description">
                最后修复效果，一页图片有48张图，超过48张图才可以下一页。
            </div>
            <img src="./image/13.png" alt="步骤5图片" class="clickable-image">
        </div>


        <hr>
        <div class="tutorial-step">
            <div class="step-title">修复壁纸模板长时间加载不出来的问题</div>
            <div class="step-title" style="font-size: 16px;">（此处可改可不改，看你自己需求，不改也没什么影响的。）</div>
            <div class="step-description">
                有时候壁纸图片会长时间一直都加载不出来，要刷新后才能加载出来。
            </div>
            <img src="./image/15.png" alt="步骤1图片" class="clickable-image">
            <div class="step-description">
                1、打开joe主题文件joe-master → core → route.php文件，找到获取壁纸分类的function _getWallpaperType($self)方法
                和获取壁纸列表的function _getWallpaperList($self)方法，下图框选的代码进行替换。
            </div>
            <img src="./image/16.png" alt="步骤2图片" class="clickable-image">
            <div class="step-description">
                2、将下面1到46行的代码替换进去。
            </div>
            <pre>
                <code>
<span>/* 获取壁纸分类 已测试 √ */</span>
<span>function _getWallpaperType($self)</span>
<span>{</span>
<span>	header('Content-Type: application/json');</span>
<span>	$self->response->setStatus(200);</span>
<span>	$json = file_get_contents("此处替换成您的专属图片分类api");</span>
<span>	$res = json_decode($json, TRUE);</span>
<span>	if ($res['errno'] == 0) {</span>
<span>		$self->response->throwJson([</span>
<span>			"code" => 1,</span>
<span>			"data" => $res['data']</span>
<span>		]);</span>
<span>	} else {</span>
<span>		$self->response->throwJson([</span>
<span>			"code" => 0,</span>
<span>			"data" => null</span>
<span>		]);</span>
<span>	}</span>
<span>}</span>
<span></span>
<span></span>
<span>/* 获取壁纸列表 已测试 √ */</span>
<span>function _getWallpaperList($self)</span>
<span>{</span>
<span>	header('Content-Type: application/json');</span>
<span>	$self->response->setStatus(200);</span>
<span>	$cid = $self->request->cid;</span>
<span>	$start = $self->request->start;</span>
<span>	$count = $self->request->count;</span>
<span>	$json = file_get_contents("此处替换成您的专属图片api");</span>
<span>	$res = json_decode($json, TRUE);</span>
<span>	if ($res['errno'] == 0) {</span>
<span>		// 数据总数</span>
<span>        $total = $res['total'];</span>
<span>		$self->response->throwJson([</span>
<span>			"code" => 1,</span>
<span>			"data" => $res['data'],</span>
<span>			"total" => $total</span>
<span>		]);</span>
<span>	} else {</span>
<span>		$self->response->throwJson([</span>
<span>			"code" => 0,</span>
<span>			"data" => null</span>
<span>		]);</span>
<span>	}</span>
<span>}</span>
<span></span>
<span></span>
<span></span>

                </code>
            </pre>

            <div class="step-description">
                3、代码替换后
            </div>
            <img src="./image/17.png" alt="步骤3图片" class="clickable-image">

            <div class="step-description">
                效果图
            </div>
            <img src="./image/19.png" alt="步骤4图片" class="clickable-image">
        </div>

    </div>


    <!-- 放大图片的容器 -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox(event)">
        <button class="close-btn" onclick="closeLightbox(event)">×</button>

        <button class="zoom-btn zoom-in-btn " id="zoom-in-btn">
            <svg t="1737107646723" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"
                p-id="6178" width="25" height="25">
                <path
                    d="M469.333333 298.666667a42.666667 42.666667 0 0 1 42.666667 42.666666v85.333334h85.333333a42.666667 42.666667 0 0 1 42.368 37.674666L640 469.333333a42.666667 42.666667 0 0 1-42.666667 42.666667h-85.333333v85.333333a42.666667 42.666667 0 0 1-37.674667 42.368L469.333333 640a42.666667 42.666667 0 0 1-42.666666-42.666667v-85.333333H341.333333a42.666667 42.666667 0 0 1-42.368-37.674667L298.666667 469.333333a42.666667 42.666667 0 0 1 42.666666-42.666666h85.333334V341.333333a42.666667 42.666667 0 0 1 37.674666-42.368L469.333333 298.666667z m0-128a298.666667 298.666667 0 1 0 207.573334 513.408l3.285333-3.84a40.448 40.448 0 0 1 3.797333-3.370667A298.666667 298.666667 0 0 0 469.333333 170.666667z m0-85.333334a384 384 0 0 1 384 384 382.122667 382.122667 0 0 1-83.968 239.658667l156.8 156.842667a42.624 42.624 0 1 1-60.330666 60.330666l-156.842667-156.8A382.122667 382.122667 0 0 1 469.333333 853.333333c-212.096 0-384-171.904-384-384s171.904-384 384-384z"
                    fill="#ffffff" p-id="6179"></path>
            </svg>


        </button>
        <button class="zoom-btn zoom-out-btn " id="zoom-out-btn">
            <svg t="1737107881395" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"
                p-id="7216" width="25" height="25">
                <path
                    d="M448.2 184c70.6 0 136.9 27.5 186.8 77.4s77.4 116.2 77.4 186.8S684.9 585.1 635 635s-116.2 77.4-186.8 77.4-136.9-27.5-186.8-77.4S184 518.7 184 448.2c0-70.6 27.5-136.9 77.4-186.8S377.6 184 448.2 184m0-88c-90.1 0-180.3 34.4-249 103.2-137.5 137.5-137.5 360.5 0 498.1 68.8 68.8 158.9 103.2 249 103.2s180.3-34.4 249-103.2c137.5-137.5 137.5-360.5 0-498.1C628.4 130.4 538.3 96 448.2 96z"
                    fill="#ffffff" p-id="7217"></path>
                <path
                    d="M697.2 653.2c-11.3 0-22.5 4.3-31.1 12.9-17.2 17.2-17.2 45.1 0 62.3l186.8 186.8c8.6 8.6 19.9 12.9 31.1 12.9 11.3 0 22.5-4.3 31.1-12.9 17.2-17.2 17.2-45.1 0-62.3L728.3 666.1c-8.6-8.6-19.8-12.9-31.1-12.9zM567.3 417.1c-8-8-19-12.9-31.1-12.9h-176c-24.3 0-44.1 19.7-44.1 44.1 0 12.2 4.9 23.2 12.9 31.1 8 8 19 12.9 31.1 12.9h176.1c24.3 0 44.1-19.7 44.1-44.1 0-12.1-5-23.2-13-31.1z"
                    fill="#ffffff" p-id="7218"></path>
            </svg>
        </button>
        <button class="zoom-btn zoom-fw-btn" id="reset-btn">
            <svg t="1737108496435" class="icon" viewBox="0 0 1251 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"
                p-id="11980" width="25" height="25">
                <path
                    d="M1017.230222 615.992889c-53.646222-82.033778-117.304889-146.944-189.041778-193.194667-80.554667-51.825778-173.283556-80.839111-275.342222-86.072889l-53.987555-2.730666V141.425778L124.700444 492.088889l374.727112 327.452444V587.662222l57.457777 0.568889c262.144 2.332444 419.612444 43.52 538.737778 177.664a882.346667 882.346667 0 0 0-78.392889-149.959111z m-127.431111-288.881778c85.617778 55.182222 160.540444 131.584 222.663111 226.531556a1012.906667 1012.906667 0 0 1 106.382222 216.462222 996.352 996.352 0 0 1 30.947556 105.073778c8.817778 44.088889-15.644444 88.177778-60.017778 105.528889a96.426667 96.426667 0 0 1-31.061333 5.12c-33.336889 0-64.341333-18.147556-80.213333-46.990223-97.905778-172.544-214.698667-226.816-465.294223-235.576889v163.157334c0 36.807111-21.333333 69.802667-54.385777 84.195555a93.297778 93.297778 0 0 1-99.100445-14.620444L34.247111 564.167111A89.770667 89.770667 0 0 1 0 493.795556c0-25.941333 10.467556-50.801778 29.354667-68.266667L456.419556 25.315556a92.728889 92.728889 0 0 1 156.216888 66.958222v135.623111c100.807111 12.629333 194.161778 45.909333 277.162667 99.271111z"
                    fill="#ffffff" p-id="11981"></path>
            </svg>
        </button>
        <img id="lightbox-img" src="" alt="放大图片">

    </div>
    <script>
        // 显示放大图片
        const images = document.querySelectorAll('.clickable-image');
        images.forEach(image => {
            image.addEventListener('click', (event) => {
                const lightbox = document.getElementById('lightbox');
                const lightboxImg = document.getElementById('lightbox-img');
                lightboxImg.src = event.target.src;
                lightbox.style.display = 'flex'; // 显示放大图片
            });
        });

        // 点击空白区域或关闭按钮关闭放大图片
        function closeLightbox(event) {
            if (event.target === event.currentTarget || event.target.classList.contains('close-btn')) {
                document.getElementById('lightbox').style.display = 'none';
            }
        }

        // 缩放功能
        const zoomInBtn = document.getElementById('zoom-in-btn');
        const zoomOutBtn = document.getElementById('zoom-out-btn');
        const lightboxImg = document.getElementById('lightbox-img');
        let scale = 1;
        let originalLeft = 0;
        let originalTop = 0;
        zoomInBtn.addEventListener('click', () => {
            scale += 0.5;
            lightboxImg.style.transform = `scale(${scale})`;
        });
        zoomOutBtn.addEventListener('click', () => {
            scale -= 0.5;
            if (scale < 0.1) scale = 0.1; // 最小缩放比例
            lightboxImg.style.transform = `scale(${scale})`;
        });

        // 移动功能
        let isDragging = false;
        let startX, startY, startLeft, startTop;
        lightboxImg.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;
            startLeft = parseInt(lightboxImg.offsetLeft);
            startTop = parseInt(lightboxImg.offsetTop);
            e.preventDefault();
        });
        lightboxImg.addEventListener('touchstart', (e) => {
            isDragging = true;
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            startLeft = parseInt(lightboxImg.offsetLeft);
            startTop = parseInt(lightboxImg.offsetTop);
            e.preventDefault();
        });
        document.addEventListener('mousemove', (e) => {
            if (isDragging) {
                const dx = e.clientX - startX;
                const dy = e.clientY - startY;
                const newLeft = startLeft + dx;
                const newTop = startTop + dy;
                // 允许图片在放大状态下超出视口一定范围
                lightboxImg.style.left = `${newLeft}px`;
                lightboxImg.style.top = `${newTop}px`;
            }
        });
        document.addEventListener('touchmove', (e) => {
            if (isDragging) {
                const dx = e.touches[0].clientX - startX;
                const dy = e.touches[0].clientY - startY;
                const newLeft = startLeft + dx;
                const newTop = startTop + dy;
                // 允许图片在放大状态下超出视口一定范围
                lightboxImg.style.left = `${newLeft}px`;
                lightboxImg.style.top = `${newTop}px`;
            }
        });
        document.addEventListener('mouseup', () => {
            isDragging = false;
        });
        document.addEventListener('touchend', () => {
            isDragging = false;
        });

        // 复位功能
        const resetBtn = document.getElementById('reset-btn');
        resetBtn.addEventListener('click', () => {
            scale = 1;
            lightboxImg.style.transform = `scale(${scale})`;
            lightboxImg.style.left = `${originalLeft}px`;
            lightboxImg.style.top = `${originalTop}px`;
        });

        // 保存图片的原始位置
        const lightboxImgElement = document.getElementById('lightbox-img');
        lightboxImgElement.addEventListener('load', () => {
            originalLeft = parseInt(lightboxImgElement.offsetLeft);
            originalTop = parseInt(lightboxImgElement.offsetTop);
        });
        var protocol = window.location.protocol;
        var domain = window.location.hostname;

        // Display the protocol and domain inside the div with id 'protocol-domain'
        document.getElementById('protocol-domain').innerText = protocol + "//" + domain + "/api/imagesort.php";
        document.getElementById('protocol-domains').innerText = protocol + "//" + domain + "/api/image.php?&cid={$cid}&start={$start}&count={$count}";
    </script>

</body>

</html>