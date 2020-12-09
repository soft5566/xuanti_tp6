<?php /*a:3:{s:63:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\stu\addall.html";i:1607157249;s:63:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\top.html";i:1606871536;s:68:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\leftMenu.html";i:1607055395;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta charset="utf-8">
    <title><?php echo htmlentities($datacfg[4]['con_value']); ?>选题系统后台管理页面</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/css/comm.css">
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <div class="layui-logo" style="margin-left: 118px; font-size: 18px; text-align: left; width: 600px;">
    <?php echo htmlentities($datacfg[4]['con_value']); ?>选题系统后台管理页面
</div>
<ul class="layui-nav layui-layout-right">
    <li class="layui-nav-item">
        <a href="javascript:;">
            <img src="/static/images/admin.jpg" class="layui-nav-img">
            <?php echo session('uloginName'); ?>
        </a>
    </li>
    <li class="layui-nav-item"><a id="logout" href="javascript:void(0);"
                                  onclick="logout('<?php echo url('/admin/manager/logout'); ?>');return false;">退了</a></li>
</ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
    <li class="layui-nav-item layui-nav-itemed">
        <a href="javascript:;">系统管理</a>
        <dl class="layui-nav-child">
            <dd class="my-txt-right"><a href="<?php echo url('/admin/manager/index'); ?>">系统参数配置</a></dd>
            <dd class="my-txt-right"><a href="<?php echo url('/admin/manager/time'); ?>">选题时间设置</a></dd>
            <dd class="my-txt-right"><a href="<?php echo url('/admin/specility/index'); ?>">管理专业</a></dd>
            <dd class="my-txt-right"><a href="<?php echo url('/admin/userm/index'); ?>">管理用户</a></dd>
            <dd class="my-txt-right"><a href="<?php echo url('/admin/userm/viewtitle'); ?>">查看选题结果</a></dd>
        </dl>
    </li>
    <li class="layui-nav-item layui-nav-itemed">
        <a href="javascript:;">学生信息管理</a>
        <dl class="layui-nav-child">
            <dd class="my-txt-right"><a href="<?php echo url('/admin/stu/index'); ?>">管理学生信息</a></dd>
            <dd class="my-txt-right"><a href="<?php echo url('/admin/stu/addall'); ?>">导入学生信息</a></dd>
            <dd class="my-txt-right"><a href="javascript:;"
                                        onclick="clrspaces('<?php echo url('/admin/manager/clrspc'); ?>');return false;">清除空格</a>
            </dd>
        </dl>
    </li>
    <li class="layui-nav-item layui-nav-itemed">
        <a href="javascript:;">题库管理</a>
        <dl class="layui-nav-child">
            <dd class="my-txt-right"><a href="<?php echo url('/admin/title/index'); ?>">管理选题</a></dd>
            <dd class="my-txt-right"><a href="<?php echo url('/admin/title/addall'); ?>">导入选题</a></dd>
        </dl>
    </li>
</ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>批量导入学生信息</legend>
        </fieldset>
        <form class="layui-form">
            <div class="layui-row">
                <div class="layui-col-md-offset1 layui-col-md10">
                    <div class="layui-form-item">
                        <label class="layui-form-label">格式说明</label>

                        <div class="layui-input-block">
                            <input class="layui-input" name="viewText" disabled=""
                                   value="学号        姓名      专业号【说明：将Excel表数据直接粘贴过来，不需要任何编辑！】"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-row">
                <div class="layui-col-md-offset1 layui-col-md10">
                    <div class="layui-form-item">
                        <label class="layui-form-label">粘贴数据</label>

                        <div class="layui-input-block">
                            <textarea class="layui-textarea" rows="20" lay-verify="required" name="allStu"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-row">
                <div class="layui-col-md-offset1 layui-col-md10">
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button type="button" lay-submit lay-filter="sub" class="layui-btn layui-btn-danger">批量添加
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="/static/js/comm.js" charset="utf-8"></script>
<script>
    layui.use(['element', 'form'], function () {
        var form = layui.form;
        window.$ = layui.$;

        form.on('submit(sub)', function (d) {
            ajax_push("<?php echo url('/admin/stu/insertAllAction'); ?>", d.field);
        });
    });
</script>
</body>
</html>