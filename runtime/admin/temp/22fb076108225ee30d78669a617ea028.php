<?php /*a:1:{s:64:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\admin\view\index\index.html";i:1607157249;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta charset="utf-8">
    <title><?php echo htmlentities($datacfg[4]['con_value']); ?>选题系统后台登陆页面</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">

</head>
<body>
<div class="layui-container">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend><h3><?php echo htmlentities($datacfg[4]['con_value']); ?>选题系统<span class="badge">后台管理登陆界面</span></h3></legend>
    </fieldset>

    <div style="padding: 20px; background-color: #F2F2F2;">
        <div class="layui-col-space15">
            <div class="layui-card">
                <form class="layui-form" method="post" action="<?php echo url('/index/login'); ?>">
                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset4 layui-col-md4">
                            <div class="layui-form-item">
                                <label class="layui-form-label">用户名</label>

                                <div class="layui-input-block">
                                    <input type="text" name="UserName" lay-reqtext="用户名只能是5-16位，由字母、数字或下划线组成！"
                                           lay-verify="required|UserName" class="layui-input"
                                           id="inputUserName" placeholder="请输入用户名">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset4 layui-col-md4">
                            <div class="layui-form-item">
                                <label for="inputPassword" class="layui-form-label">密&nbsp;&nbsp;&nbsp;码</label>

                                <div class="layui-input-block">
                                    <input type="password" name="UserPwd" lay-reqtext="密码只能是6-16位，由字母、数字或下划线组成！"
                                           lay-verify="required|UserPwd" class="layui-input"
                                           id="inputPassword" placeholder="请输入密码">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset4 layui-col-md4">
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button id="btnsub" type="button" class="layui-btn" lay-submit="" lay-filter="sub">登&nbsp;&nbsp;陆</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/static/js/comm.js" charset="utf-8"></script>
<script>
    layui.use(['form'], function () {
        var form = layui.form;
        window.$ = layui.$;

        //自定义验证规则
        form.verify({
            UserName: [
                /^[a-zA-Z0-9_]{5,16}$/,
                '用户名只能是5-16位，由字母、数字或下划线组成！'
            ]
            , UserPwd: [
                /^[a-zA-Z0-9_]{6,16}$/
                , '密码只能是6-16位，由字母、数字或下划线组成！'
            ]
        });

        $(document).keypress(function (event) {
            if (event.which === 13) {
                $('#btnsub').click();
            }
        });

        //监听提交
        form.on('submit(sub)', function (data) {
            var url = '<?php echo url("/admin/index/login"); ?>';
            ajax_push(url, data.field);
        });
    });
</script>
</body>
</html>