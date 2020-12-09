<?php /*a:3:{s:68:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\specility\index.html";i:1607157248;s:63:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\top.html";i:1606871536;s:68:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\leftMenu.html";i:1607055395;}*/ ?>
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
            <legend>管理专业</legend>
        </fieldset>
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md-offset2 layui-col-md8">
                <div class="layui-card">
                    <table class="layui-table" id="demo" lay-filter="demo"></table>

                    <script type="text/html" id="toolbarDemo">
                        <div class="layui-btn-container">
                            <button type="button" class="layui-btn layui-btn-sm" lay-submit lay-filter="addspec">添加专业
                            </button>
                            <button type="button" class="layui-btn layui-btn-sm" lay-submit lay-filter="addaspec">批量添加专业
                            </button>
                        </div>
                    </script>

                    <script type="text/html" id="checkboxTpl">
                        <!-- 这里的 checked 的状态只是演示 -->
                        <input type="checkbox" name="sp_open" value="{{d.sp_Id}}" lay-skin="switch"
                               lay-filter="lockDemo"
                               {{ d.sp_Open== 0 ? 'lay-text="开放|关闭" checked' : 'lay-text="开放|关闭"' }}>
                    </script>

                    <script type="text/html" id="barDemo">
                        <a class="layui-btn layui-btn-xs" lay-event="modify">编辑</a>
                        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/static/js/comm.js" charset="utf-8"></script>
<script>
    layui.use(['table', 'element', 'form'], function () {
        var table = layui.table
            , form = layui.form;
        window.$ = layui.$;

        //表格渲染
        table.render({
            elem: '#demo'
            , url: '<?php echo url("/admin/specility/getSpecility"); ?>'
            , toolbar: '#toolbarDemo'
            , cols: [[
                {type: 'numbers', title: '序号'}
                , {field: 'sp_Id', title: '专业编号', width: 110, align: 'center', sort: true}
                , {field: 'sp_Name', title: '专业名称', align: 'center', sort: true}
                , {field: 'sp_Classes', title: '专业类别', align: 'center', sort: true}
                , {field: 'sp_Open', title: '是否开放', width: 110, templet: '#checkboxTpl', unresize: true}
                , {fixed: 'right', title: '操作', toolbar: '#barDemo'}
            ]]
            , page: false
            , done: function (res, curr, count) {
                var index = 0;
                // 监听指定开关
                form.on('switch(lockDemo)', function (data) {
                    ajax_push('<?php echo url("/admin/specility/openorclose"); ?>', {
                        'spid': data.value,
                        'isnot': data.elem.checked
                    });
                });
                //监听工具条
                table.on('tool(demo)', function (obj) {
                    var data = obj.data;
                    if (obj.event === 'del') {
                        index = layer.confirm('真的删除【' + data.sp_Name + '】吗？', {
                            icon: 3
                            , title: '删除'
                            , yes: function (index) {
                                //向服务端发送删除指令
                                ajax_push('<?php echo url("/admin/specility/delete"); ?>', {'spid': data.sp_Id}, index, obj);
                            }
                        });
                    } else if (obj.event === 'modify') {
                        layer.open({
                            type: 1
                            , title: '修改专业'
                            , shadeClose: false  // 点击遮罩关闭
                            , area: ['500px', '260px']
                            , content: $('#modifyModel')
                            , success: function (layero, index) {
                                $('#modifyspid').val(data.sp_Id);
                                $('#modifyspname').val(data.sp_Name);
                                $('#modifyspclass').val(data.sp_Classes);

                                // 修改专业表单提交
                                form.on('submit(submodify)', function (d) {
                                    ajax_push('<?php echo url("/admin/specility/modifyAction"); ?>', {'data': d.field}, index);
                                });
                            }
                        });
                    }
                });
                // 监听添加专业按钮
                form.on('submit(addspec)', function (data) {
                        layer.open({
                            type: 1
                            , title: '添加专业'
                            , shadeClose: false  // 点击遮罩关闭
                            , area: ['500px', '260px']
                            , content: $('#addModal')
                            , success: function (layero, index) {
                                // 监听添加专业表单提交
                                form.on('submit(subadd)', function (d) {
                                    ajax_push('<?php echo url("/admin/specility/add"); ?>', {'data': d.field}, index);
                                });
                            }
                        });
                    }
                );
                // 监听批量添加专业按钮
                form.on('submit(addaspec)', function (data) {
                        layer.open({
                            type: 1
                            , title: '批量添加专业'
                            , shadeClose: false  // 点击遮罩关闭
                            , area: ['500px', '260px']
                            , content: $('#addAllModal')
                            , success: function (layero, index) {
                                // 监听批量添加专业表单提交
                                form.on('submit(subadda)', function (d) {
                                    ajax_push('<?php echo url("/admin/specility/addAll"); ?>', {'data': d.field}, index);
                                });
                            }
                        });
                    }
                );
                //表单验证
                form.verify({
                    spname: [
                        /^[\u4e00-\u9fa5]{2,5}(\d{4})[-][\d]{1,2}$/
                        , '专业名称。\n\n格式如：电商2012-1'
                    ]
                    , spclass: [
                        /^[\u4e00-\u9fa5]{3,6}$/
                        , '比如：计算机专业，就写“计算机类”'
                    ]
                });
            }
        });

    });
</script>
</body>
</html>
<div id="addModal" style="display: none; padding: 20px;">
    <form class="layui-form">
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label for="spname" class="layui-form-label">专业名称</label>

                    <div class="layui-input-block">
                        <input type="text" name="spname" lay-reqtext="请输入专业名称！" lay-verify="required|spname"
                               maxlength="14" class="layui-input" id="spname" placeholder="专业名称，格式如：电商2012-1">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label for="spclass" class="layui-form-label">专业类别</label>

                    <div class="layui-input-block">
                        <input type="text" name="spclass" lay-reqtext="请输入专业类别！" lay-verify="required|spclass"
                               maxlength="14" class="layui-input" id="spclass" placeholder="比如：计算机专业，就写“计算机类”">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" lay-submit lay-filter="subadd">添加</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="addAllModal" style="display: none; padding: 20px;">
    <form class="layui-form">
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label for="allspclass" class="layui-form-label">专业类别</label>

                    <div class="layui-input-block">
                        <textarea name="allspclass" lay-reqtext="请输入专业类别！" lay-verify="required"
                                  class="layui-textarea" id="allspclass" placeholder="Excel表格数据直接粘贴过来即可。
比如：
    电商2016-1	计算机类
    电商2016-2	计算机类
"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" lay-submit lay-filter="subadda">添加</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modifyModel" style="display: none; padding: 20px;">
    <form class="layui-form">
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label for="spname" class="layui-form-label">专业名称</label>

                    <div class="layui-input-block">
                        <input type="text" name="modifyspname" lay-reqtext="请输入专业名称！"
                               lay-verify="required|spname" id="modifyspname"
                               maxlength="14" class="layui-input"
                               placeholder="专业名称，格式如：电商2012-1">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label for="modifyspclass" class="layui-form-label">专业类别</label>

                    <div class="layui-input-block">
                        <input type="text" name="modifyspclass" lay-reqtext="请输入专业名称！"
                               lay-verify="required|spclass" id="modifyspclass"
                               maxlength="14" class="layui-input"
                               placeholder="比如：计算机专业，就写“计算机类”">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="hidden" id="modifyspid" name="modifyspid">
                        <button type="button" lay-submit lay-filter="submodify" class="layui-btn">修 改</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>