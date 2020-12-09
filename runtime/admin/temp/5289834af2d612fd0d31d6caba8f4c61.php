<?php /*a:3:{s:64:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\title\index.html";i:1607431661;s:63:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\top.html";i:1606871536;s:68:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\leftMenu.html";i:1607055395;}*/ ?>
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
            <legend>选题管理</legend>
        </fieldset>
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <table class="layui-table" id="demo" lay-filter="demo"></table>

                    <script type="text/html" id="toolbarDemo">
                        <div class="layui-btn-container layui-inline">
                            <button class="layui-btn layui-btn-danger" lay-event="delAllTitle">删除勾选</button>
                            <button class="layui-btn" lay-event="addTitle">添加选题</button>
                        </div>
                        <div class="demoTable layui-inline">
                            搜索：
                            <div class="layui-inline">
                                <input class="layui-input" name="keys" size="58" id="demoReload"
                                       placeholder="多个关键字，用空格隔开，可同时搜索：题目、导师、手机等">
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
        window.$ = layui.jquery;

        //表格渲染
        table.render({
            elem: '#demo'
            , url: '<?php echo url("/admin/Title/getTitle"); ?>'
            , toolbar: '#toolbarDemo'
            , cols: [[
                {type: 'checkbox'}
                , {type: 'numbers', title: '序号'}
                , {field: 'c_Id', title: '编号', width: 88, align: 'center', sort: true}
                , {field: 'c_Num', title: '题号', width: 88, align: 'center', sort: true}
                , {field: 'c_Title', title: '题目', align: 'center', sort: true}
                , {field: 'c_Tutor', title: '导师', width: 88, align: 'center', sort: true}
                , {field: 'c_zhichen', title: '职称', width: 118, align: 'center', sort: true}
                , {field: 'c_Phone', title: '手机', width: 118, align: 'center', sort: true}
                , {field: 'c_People', title: '合作人数', width: 118, align: 'center', sort: true}
                , {field: 'c_Left', title: '可选人数', width: 118, align: 'center', sort: true}
                , {field: 'c_Class', title: '题目方向', width: 118, align: 'center', sort: true}
                , {field: 'c_Design', title: '题目类别', width: 118, align: 'center', sort: true}
                , {fixed: 'right', title: '操作', width: 158, toolbar: '#barDemo'}
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
            ctitle: [
                /^[\s\S]{6,100}$/
                , '选题题目为6-100个字符'
            ]
            , ctutor: [
                /^[\u4e00-\u9fa5]{2,10}$/
                , '导师姓名为2-10个汉字'
            ]
        });

        //头工具栏事件
        table.on('toolbar(demo)', function (obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            var allData = checkStatus.data;
            switch (obj.event) {
                case 'delAllTitle':
                    if (allData.length === 0) {
                        parent.layer.msg('请先勾选要删除的行！', {icon: 2});
                        return;
                    } else {
                        layer.confirm('删除后无法恢复！\n\n确定要批量删除？', {
                            icon: 3
                            , title: '批量删除'
                            , yes: function (index) {
                                var id_str = '';
                                for (var i = 0; i < allData.length; i++) {
                                    id_str += allData[i].c_Id + ',';
                                }
                                id_str = id_str.substr(0, id_str.length - 1);
                                //向服务端发送删除指令
                                ajax_push("<?php echo url('/admin/Title/delete'); ?>", {
                                    'arrayid': id_str,
                                    'dt': new Date().getTime()
                                }, index)
                            }
                        });
                    }
                    break;
                case 'addTitle':
                    layer.open({
                        type: 1
                        , title: '添加选题'
                        , shadeClose: false //点击遮罩关闭
                        , area: ['580px', '600px']
                        , content: $('#addModal')
                        , success: function (layero, index) {
                            // 监听添加专业表单提交
                            form.on('submit(addsub)', function (data) {
                                ajax_push("<?php echo url('/admin/title/insertAction'); ?>", data.field, index);
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
                layer.confirm('真的删除题目【' + data.c_Title + '】吗？', {
                    icon: 3
                    , title: '删除'
                    , yes: function (index) {
                        //向服务端发送删除指令
                        ajax_push('<?php echo url("/admin/title/delete"); ?>', {'cid': data.c_Id}, index, obj, 'GET');
                    }
                });
            } else if (obj.event === 'modify') {
                layer.open({
                    type: 1
                    , title: '修改选题'
                    , shadeClose: false //点击遮罩关闭
                    , area: ['580px', '630px']
                    , content: $('#modifyModal')
                    , success: function (layero, index) {
                        form.val('formmodify', {
                            'modifycid': data.c_Id
                            , 'modifytitleid': data.c_Num
                            , 'modifyctitle': data.c_Title
                            , 'modifyctutor': data.c_Tutor
                            , 'modifyczhichen': data.c_zhichen
                            , 'modifycphone': data.c_Phone
                            , 'modifycdesign': data.c_Design
                        });
                        $('#modifycclass').val(data.c_Class);
                        $('#modifycpeople').val(data.c_People);
                        $('#modifycleft').val(data.c_Left);
                        form.render();
                        // 监听添加专业表单提交
                        form.on('submit(modifysub)', function (d) {
                            ajax_push("<?php echo url('/admin/title/modifyAction'); ?>", d.field, index);
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
                    <label class="layui-form-label">题目题号</label>

                    <div class="layui-input-block">
                        <input type="text" name="titleid" title="题号自动生成！"
                               lay-verify="required" value="<?php echo htmlentities($cnumMax); ?>"
                               class="layui-input" id="titleid" readonly
                               placeholder="题号自动生成">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">选题题目</label>

                    <div class="layui-input-block">
                        <input type="text" name="ctitle" lay-reqtext="请输入选题题目！"
                               lay-verify="required|ctitle"
                               maxlength="100" class="layui-input" id="ctitle"
                               placeholder="选题题目应不多于100个字符">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">导师姓名</label>

                    <div class="layui-input-block">
                        <input type="text" name="ctutor" lay-reqtext="请输入导师姓名！"
                               lay-verify="required|ctutor" class="layui-input" id="ctutor"
                               placeholder="导师姓名为2-10个汉字">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">导师职称</label>

                    <div class="layui-input-block">
                        <input type="text" name="czhichen" lay-reqtext="请输入导师职称！"
                               lay-verify="required|ctutor" class="layui-input" id="czhichen"
                               placeholder="导师职称为2-10个汉字，如：讲师、教授、工程师等">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">导师手机</label>

                    <div class="layui-input-block">
                        <input type="text" name="cphone" lay-reqtext="请输入导师手机号码！"
                               lay-verify="required|phone" class="layui-input" id="cphone"
                               placeholder="导师手机号码" maxlength="11">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">题目类别</label>

                    <div class="layui-input-block">
                        <input type="text" name="cdesign" lay-reqtext="请输入题目方向！"
                               lay-verify="required|ctutor" class="layui-input" id="cdesign"
                               placeholder="题目方向为2-10个汉字，如：论文、设计、设计或论文">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">题目方向</label>

                    <div class="layui-input-block">
                        <select name="cclass" id="cclass" lay-verify="required">
                            <option value="">请选择题目方向</option>
                            <?php if(is_array($spclass) || $spclass instanceof \think\Collection || $spclass instanceof \think\Paginator): $i = 0; $__LIST__ = $spclass;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo htmlentities($vo['sp_Classes']); ?>"><?php echo htmlentities($vo['sp_Classes']); ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">合作人数</label>

                    <div class="layui-input-block">
                        <select id="cpeople" name="cpeople" class="form-control">
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" lay-submit="" lay-filter="addsub">添加</button>
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
                    <label class="layui-form-label">题目题号</label>

                    <div class="layui-input-block">
                        <input type="text" name="modifytitleid" title="题号自动生成！"
                               lay-verify="required"
                               class="layui-input" id="modifytitleid" readonly
                               placeholder="题号自动生成">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">选题题目</label>

                    <div class="layui-input-block">
                        <input type="text" name="modifyctitle" lay-reqtext="请输入选题题目！"
                               lay-verify="required|ctitle"
                               maxlength="100" class="layui-input" id="modifyctitle"
                               placeholder="选题题目应不多于100个字符">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">导师姓名</label>

                    <div class="layui-input-block">
                        <input type="text" name="modifyctutor" lay-reqtext="请输入导师的姓名！"
                               lay-verify="required|ctutor" class="layui-input" id="modifyctutor"
                               placeholder="导师姓名为2-10个汉字">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">导师职称</label>

                    <div class="layui-input-block">
                        <input type="text" name="modifyczhichen" lay-reqtext="请输入导师的职称！"
                               lay-verify="required|ctutor" class="layui-input" id="modifyczhichen"
                               placeholder="导师职称为2-10个汉字">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">导师手机</label>

                    <div class="layui-input-block">
                        <input type="text" name="modifycphone" lay-reqtext="请输入导师的手机号码！"
                               lay-verify="required|phone" class="layui-input" id="modifycphone"
                               placeholder="请输入导师的手机号码" maxlength="11">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">题目类别</label>

                    <div class="layui-input-block">
                        <input type="text" name="modifycdesign" lay-reqtext="请输入题目类别！"
                               lay-verify="required|ctutor" class="layui-input" id="modifycdesign"
                               placeholder="题目类别为2-10个汉字">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">专业类别</label>

                    <div class="layui-input-block">
                        <select name="modifycclass" id="modifycclass" lay-verify="required">
                            <option value="">请选择专业类别</option>
                            <?php if(is_array($spclass) || $spclass instanceof \think\Collection || $spclass instanceof \think\Paginator): $i = 0; $__LIST__ = $spclass;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo htmlentities($vo['sp_Classes']); ?>"><?php echo htmlentities($vo['sp_Classes']); ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">合作人数</label>

                    <div class="layui-input-block">
                        <select id="modifycpeople" name="modifycpeople" class="form-control">
                            <?php $__FOR_START_619279695__=1;$__FOR_END_619279695__=6;for($i=$__FOR_START_619279695__;$i < $__FOR_END_619279695__;$i+=1){ ?>
                            <option value="<?php echo htmlentities($i); ?>"><?php echo htmlentities($i); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <label class="layui-form-label">可选人数</label>

                    <div class="layui-input-block">
                        <select id="modifycleft" name="modifycleft" class="form-control">
                            <?php $__FOR_START_1864419109__=1;$__FOR_END_1864419109__=6;for($i=$__FOR_START_1864419109__;$i < $__FOR_END_1864419109__;$i+=1){ ?>
                            <option value="<?php echo htmlentities($i); ?>"><?php echo htmlentities($i); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md11">
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="hidden" id="modifycid" name="modifycid">
                        <button type="button" class="layui-btn" lay-submit="" lay-filter="modifysub">修改</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>