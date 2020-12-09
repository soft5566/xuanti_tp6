<?php /*a:3:{s:66:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\manager\index.html";i:1607157249;s:63:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\top.html";i:1606871536;s:68:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\public\leftMenu.html";i:1607055395;}*/ ?>
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
            <legend>系统参数配置</legend>
        </fieldset>
        <div style="padding: 20px; background-color: #F2F2F2;">
            <form class="layui-form">
                <div class="layui-row layui-col-space15">
                    <div class="layui-card">
                        <div class="layui-card-header">
                            <label class="layui-col-md3 my-txt-center">参数名</label>
                            <label class="layui-col-md2 my-txt-center">参数值</label>
                            <label class="layui-col-md7 my-txt-center">参数功能说明</label>
                        </div>
                        <div class="layui-card-body">
                            <?php if(is_array($datacfg) || $datacfg instanceof \think\Collection || $datacfg instanceof \think\Paginator): $i = 0; $__LIST__ = $datacfg;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <div class="layui-form-item">
                                <div class="layui-col-md-offset1 layui-col-md1">
                                    <input type="hidden" name="<?php echo htmlentities($vo['con_key']); ?>_id" value="<?php echo htmlentities($vo['con_id']); ?>">
                                    <input type="text" class="layui-input" name="<?php echo htmlentities($vo['con_key']); ?>_key"
                                           maxlength="16" readonly id="<?php echo htmlentities($vo['con_key']); ?>_key" value="<?php echo htmlentities($vo['con_key']); ?>"
                                           placeholder="参数名，不能为空">
                                </div>
                                <div class="layui-col-md-offset1 layui-col-md2">
                                    <input type="text" class="layui-input" id="<?php echo htmlentities($vo['con_key']); ?>_value"
                                           name="<?php echo htmlentities($vo['con_key']); ?>_value"
                                           maxlength="16" placeholder="参数值，不能为空" value="<?php echo htmlentities($vo['con_value']); ?>">
                                </div>
                                <div class="layui-col-md-offset1 layui-col-md6">
                                            <textarea class="layui-textarea" name="<?php echo htmlentities($vo['con_key']); ?>_inst"
                                                      placeholder="参数说明，不能为空"><?php echo $vo['con_inst']; ?></textarea>
                                </div>
                            </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            <div class="layui-form-item">
                                <div class="layui-col-md-offset1 layui-col-md9">
                                    <button type="button" lay-submit lay-filter="demo1"
                                            class="layui-btn layui-btn-danger">确定修改配置
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/static/js/comm.js" charset="utf-8"></script>
<script>
    layui.use(['form', 'element'], function () {
        var form = layui.form;
        window.$ = layui.$;

        //监听提交
        form.on('submit(demo1)', function (data) {
            var cfg_numofpage_value = $('#cfg_numofpage_value').val();
            var patrn = /^[1-9]\d*$/;
            if (!patrn.exec(cfg_numofpage_value)) {
                layer.alert('每页显示记录数，只能为正整数！', {icon: 5});
            } else {
                var url = '<?php echo url("/admin/manager/modifyAction"); ?>';
                ajax_push(url, data.field);
            }
        });

    });
</script>
</body>
</html>