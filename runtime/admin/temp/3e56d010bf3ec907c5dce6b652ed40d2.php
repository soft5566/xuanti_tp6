<?php /*a:3:{s:62:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\stu\index.html";i:1607431607;s:63:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\top.html";i:1606871536;s:68:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\leftMenu.html";i:1607055395;}*/ ?>
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
            <legend>学生信息管理</legend>
        </fieldset>
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <table class="layui-table" id="demo" lay-filter="demo"></table>

                    <script type="text/html" id="toolbarDemo">
                        <div class="layui-btn-container layui-inline">
                            <button class="layui-btn layui-btn-danger" lay-event="delAllStu">删除勾选</button>
                            <button class="layui-btn" lay-event="addstu">添加学生</button>
                        </div>
                        <div class="demoTable layui-inline">
                            搜索：
                            <div class="layui-inline">
                                <input class="layui-input" name="keys" size="58" id="demoReload"
                                       placeholder="多个关键字，用空格隔开，可同时搜索：学号、姓名、专业">
                            </div>
                            <button id="ser" class="layui-btn" data-type="searchreload">搜索</button>
                        </div>
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
    //JavaScript代码区域
    layui.use(['element', 'table', 'form'], function () {
        var table = layui.table
            , form = layui.form;
        window.$ = layui.$;

        //表格渲染
        table.render({
            elem: '#demo'
            , url: '<?php echo url("/admin/stu/getStu"); ?>'
            , toolbar: '#toolbarDemo'
            , cols: [[
                {type: 'checkbox'}
                , {type: 'numbers', title: '序号'}
                , {field: 's_Id', title: '编号', align: 'center', hide: true, sort: true}
                , {field: 's_Num', title: '学号', align: 'center', width: 168, sort: true}
                , {field: 's_Name', title: '姓名', align: 'center', width: 118, sort: true}
                , {field: 's_Pwd', title: '密码', align: 'center', sort: true}
                , {field: 's_Sex', title: '性别', align: 'center', width: 88, sort: true}
                , {field: 'sp_Name', title: '专业', align: 'center', width: 168, sort: true}
                , {field: 's_Phone', title: '电话', align: 'center', width: 168, sort: true}
                , {field: 's_Email', title: '邮箱', align: 'center', width: 188, sort: true}
                , {field: 's_Datetime', title: '注册日期', align: 'center', width: 218, sort: true}
                , {fixed: 'right', title: '操作', width: 168, toolbar: '#barDemo'}
            ]]
            , page: {
                layout: ['prev', 'page', 'next', 'count', 'skip', 'limit']
                , groups: 10
                , first: '首页'
                , prev: '上一页'
                , next: '下一页'
                , last: '尾页'
            }
            , limit: "<?php echo htmlentities($datacfg[0]['con_value']); ?>"
            , limits: ["<?php echo htmlentities($datacfg[0]['con_value']); ?>", 100, 300, 500, 1000]
            , id: 'testReload'
        });

        // 搜索功能 start
        var active = {
            searchreload: function () {
                //执行重载
                table.reload('testReload', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    , where: {
                        keys: {
                            key: $('#demoReload').val()
                            , act: 'ser'
                        }
                    }
                }, 'data');
            }
        };

        $('body').on('click', '#ser', function () {
            var keys = $('#demoReload').val();
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
            $('#demoReload').val(keys);
            $('#demoReload').focus();
        });

        $('body').keypress(function (event) {
            if (event.which === 13) {
                $('#ser').click();
            }
        });
        // 搜索功能 end

        //自定义验证规则
        form.verify({
            InputNum: [
                /^[0-9]{14}$/
                , '学号14位，由数字组成'
            ]
            , InputName: [
                /^[\u4e00-\u9fa5]{2,10}$/
                , '姓名只能是汉字，2-10个'
            ]
        });

        //头工具栏事件
        table.on('toolbar(demo)', function (obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            var allData = checkStatus.data;
            switch (obj.event) {
                case 'delAllStu':
                    if (allData.length === 0) {
                        parent.layer.msg('请先勾选要删除的行！', {icon: 2});
                        return;
                    } else {
                        layer.confirm('删除后无法恢复！<br><br>确定要删除？', {
                            icon: 3
                            , title: '批量删除'
                            , yes: function (index) {
                                var id_str = '';
                                for (var i = 0; i < allData.length; i++) {
                                    id_str += allData[i].s_Id + ',';
                                }
                                id_str = id_str.substr(0, id_str.length - 1);

                                //向服务端发送删除指令
                                ajax_push("<?php echo url('/admin/stu/delete'); ?>", {
                                        'arrayid': id_str,
                                        'dt': new Date().getTime()
                                    }
                                    , index);
                            }
                        });
                    }
                    break;
                case 'addstu':
                    layer.open({
                        type: 1
                        , title: '添加学生信息'
                        , shadeClose: false //点击遮罩关闭
                        , area: ['500px', '460px']
                        , content: $('#addModal')
                        , success: function (layero, index) {
                            // 监听添加专业表单提交
                            form.on('submit(subadd)', function (data) {
                                ajax_push("<?php echo url('/admin/stu/insertAction'); ?>", data.field, index);
                            });
                        }
                    });
                    break;
            }
        });

        //监听工具条
        table.on('tool(demo)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {
                layer.confirm('真的删除学生【' + data.s_Name + '】吗？', {
                    icon: 3
                    , title: '删除'
                    , yes: function (index) {
                        //向服务端发送删除指令
                        ajax_push('<?php echo url("/admin/stu/delete"); ?>', {'sid': data.s_Id}, index, obj, 'GET');
                    }
                });
            } else if (obj.event === 'modify') {
                layer.open({
                    type: 1
                    , title: '修改学生信息'
                    , shadeClose: false //点击遮罩关闭
                    , area: ['500px', '460px']
                    , content: $('#modifyModal')
                    , success: function (layero, index) {
                        form.val('formmodify', {
                            'modifysid': data.s_Id
                            , 'modifyInputNum': data.s_Num
                            , 'mofifyInputName': data.s_Name
                            , 'modifyInputSex': data.s_Sex
                            , 'modifyInputPhone': data.s_Phone
                            , 'modifyInputEmail': data.s_Email
                        });
                        $('#modifyInputSC').val(data.s_SC);
                        form.render();
                        // 监听添加专业表单提交
                        form.on('submit(submodify)', function (d) {
                            ajax_push("<?php echo url('/admin/stu/modifyAction'); ?>", d.field, index);
                        });
                    }
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
                    <label class="layui-form-label">学号</label>

                    <div class="layui-input-block">
                        <input type="text" name="InputNum" lay-reqtext="请输入学号！"
                               lay-verify="required|InputNum"
                               maxlength="14" class="layui-input" id="InputNum"
                               placeholder="必填项，学号由14位数字组成">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">姓名</label>

                    <div class="layui-input-block">
                        <input type="text" name="InputName" lay-reqtext="请输入姓名！"
                               lay-verify="required|InputName"
                               maxlength="10" class="layui-input" id="InputName"
                               placeholder="必填项，姓名只能由2-10汉字组成">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">性别</label>

                    <div class="layui-input-block">
                        <input type="radio" name="InputSex" value="男" title="男" checked="">
                        <input type="radio" name="InputSex" value="女" title="女">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">手机号</label>

                    <div class="layui-input-block">
                        <input type="tel" name="InputPhone" lay-reqtext="请输入手机号！"
                               maxlength="11" class="layui-input" id="InputPhone"
                               placeholder="必填项，手机号">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">邮箱</label>

                    <div class="layui-input-block">
                        <input type="email" name="InputEmail" lay-reqtext="请输入填写常用邮箱！"
                               maxlength="30" class="layui-input" id="InputEmail"
                               placeholder="填写常用邮箱">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">专业</label>

                    <div class="layui-input-block">
                        <select name="InputSC" id="InputSC" lay-verify="required">
                            <option value="">请选择专业</option>
                            <?php if(is_array($spname) || $spname instanceof \think\Collection || $spname instanceof \think\Paginator): $i = 0; $__LIST__ = $spname;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo htmlentities($vo['sp_Id']); ?>"><?php echo htmlentities($vo['sp_Name']); ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" lay-submit="" lay-filter="subadd">添加</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="modifyModal" style="display: none; padding: 20px;">
    <form class="layui-form" lay-filter="formmodify">
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">学号</label>

                    <div class="layui-input-block">
                        <input type="text" name="modifyInputNum" lay-reqtext="请输入学号！"
                               lay-verify="required|InputNum"
                               maxlength="14" class="layui-input" id="modifyInputNum"
                               placeholder="必填项，学号由14位数字组成">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">姓名</label>

                    <div class="layui-input-block">
                        <input type="text" name="mofifyInputName" lay-reqtext="请输入姓名！"
                               lay-verify="required|InputName"
                               maxlength="10" class="layui-input" id="mofifyInputName"
                               placeholder="必填项，姓名只能由2-10汉字组成">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">性别</label>

                    <div class="layui-input-block">
                        <input id="male" type="radio" name="modifyInputSex" value="男" title="男"/>
                        <input id="female" type="radio" name="modifyInputSex" value="女" title="女"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">手机号</label>

                    <div class="layui-input-block">
                        <input type="tel" name="modifyInputPhone" lay-reqtext="请输入手机号！"
                               maxlength="11" class="layui-input"
                               id="modifyInputPhone" placeholder="必填项，手机号">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">邮箱</label>

                    <div class="layui-input-block">
                        <input type="email" name="modifyInputEmail" lay-reqtext="请输入填写常用邮箱！"
                               maxlength="30" class="layui-input"
                               id="modifyInputEmail" placeholder="填写常用邮箱">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">专业</label>

                    <div class="layui-input-block">
                        <select name="modifyInputSC" id="modifyInputSC" lay-verify="required">
                            <option value="">请选择专业</option>
                            <?php if(is_array($spname) || $spname instanceof \think\Collection || $spname instanceof \think\Paginator): $i = 0; $__LIST__ = $spname;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo htmlentities($vo['sp_Id']); ?>"><?php echo htmlentities($vo['sp_Name']); ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="hidden" id="modifysid" name="modifysid">
                        <button type="button" class="layui-btn" lay-submit="" lay-filter="submodify">修改</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>