<?php /*a:3:{s:68:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\userm\viewtitle.html";i:1607157248;s:63:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\top.html";i:1606871536;s:68:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\leftMenu.html";i:1607055395;}*/ ?>
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
    <script>
        function chkNull() {
            var snum = document.getElementById("stunum").value;
            var sname = document.getElementById("stuname").value;
            var snum = snum.replace(/\s+/g, "");
            var sname = sname.replace(/\s+/g, "");
            if (sname == "" && snum == "") {
                alert("请输入【学号】 或 【姓名】!\n\n学号、姓名不能为空白字符！");
                return false;
            }
            return true;
        }
    </script>
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
            <legend>查看选题结果</legend>
        </fieldset>
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <table class="layui-table" id="demo" lay-filter="demo"></table>

                    <script type="text/html" id="toolbarDemo">
                        <div class="layui-btn-container">
                            <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="delAllTitle">删除所有选题记录
                            </button>
                        </div>
                    </script>

                    <script type="text/html" id="barDemo">
                        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/static/js/comm.js" charset="utf-8"></script>
<script>
    layui.use(['element', 'table', 'layer', 'form'], function () {
        var form = layui.form
            , table = layui.table;
        window.$ = layui.jquery

        //表格渲染
        table.render({
            elem: '#demo'
            , url: '<?php echo url("/admin/userm/getSelResult"); ?>'
            , toolbar: '#toolbarDemo'
            , cols: [[
                {type: 'checkbox'}
                , {type: 'numbers', title: '序号'}
                , {field: 's_num', title: '学号', align: 'center', width: 138, sort: true}
                , {field: 's_name', title: '姓名', align: 'center', width: 98, sort: true}
                , {field: 's_sex', title: '性别', align: 'center', width: 68, sort: true}
                , {field: 'sp_name', title: '专业', align: 'center', width: 118, sort: true}
                , {field: 's_phone', title: '手机', align: 'center', width: 118, sort: true}
                , {field: 's_email', title: '邮箱', align: 'center', width: 168, sort: true}
                , {field: 'c_num', title: '题号', align: 'center', width: 68, sort: true}
                , {field: 'c_title', title: '题目', align: 'center', sort: true}
                , {field: 'c_tutor', title: '导师', align: 'center', width: 98, sort: true}
                , {field: 'c_zhichen', title: '职称', align: 'center', width: 118, sort: true}
                , {field: 'c_phone', title: '手机', align: 'center', width: 118, sort: true}
                , {field: 'r_order', title: '选题时间', align: 'center', width: 168, sort: true}
                , {fixed: 'right', title: '操作', width: 68, toolbar: '#barDemo'}
            ]]
            , page: false
        });

        var index = 0;
        //头工具栏事件
        table.on('toolbar(demo)', function (obj) {
            var checkStatus = table.checkStatus('demo');
            var allData = table.cache.demo;
            switch (obj.event) {
                case 'delAllTitle':
                    if (checkStatus.data.length === 0) {
                        parent.layer.msg('请先选择要删除的行！', {icon: 2});
                        return;
                    } else {
                        index = layer.confirm('删除后无法恢复！\n\n确定要批量删除？', {
                            icon: 3
                            , title: '批量删除'
                            , yes: function (index) {
                                var id_str = '';
                                for (var i = 0; i < allData.length; i++) {
                                    if (allData[i].LAY_CHECKED) {
                                        id_str += allData[i].r_id + ',';
                                    }
                                }
                                id_str = id_str.substr(0, id_str.length - 1);
                                //向服务端发送删除指令
                                ajax_push("<?php echo url('/admin/userm/deleteAllTitle'); ?>", {
                                    'arrayid': id_str,
                                    'dt': new Date().getTime()
                                }, index);
                            }
                        });
                    }
            }
        });

        //监听工具条
        table.on('tool(demo)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {
                index = layer.confirm('真的删除【' + data.s_name + '】的选题吗？', {
                    icon: 3
                    , title: '删除'
                    , yes: function (index) {
                        //向服务端发送删除指令
                        ajax_push("<?php echo url('/admin/userm/deleteTitle'); ?>", {'rid': data.r_id}, index, obj);
                    }
                });

            }
        });
    });
</script>
</body>
</html>