<?php /*a:1:{s:63:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\home\view\index\index.html";i:1607158247;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta charset="utf-8">
    <title><?php echo htmlentities($datacfg[4]['con_value']); ?>选题系统学生登陆页面</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
</head>
<body>
<div class="layui-container">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend><?php echo htmlentities($datacfg[4]['con_value']); ?>选题系统学生登陆页面<a
                href="<?php echo url('/home/index/inst'); ?>" target="_blank"
                class="layui-btn layui-btn-danger layui-btn-radius layui-btn-xs">选题操作说明</a></legend>
    </fieldset>

    <div style="padding: 20px; background-color: #F2F2F2;">
        <div class="layui-col-space15">
            <div class="layui-card">
                <form class="layui-form">
                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset4 layui-col-md4">
                            <div class="layui-form-item">
                                <label for="UserNum" class="layui-form-label">学号</label>

                                <div class="layui-input-block">
                                    <input type="text" name="UserNum" lay-reqtext="请输入14位学号！"
                                           lay-verify="required|number|usernum"
                                           maxlength="14" autocomplete="off" class="layui-input" id="UserNum"
                                           value="<?php echo session('stuNum'); ?>" placeholder="请输入14位学号！">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset4 layui-col-md4">
                            <div class="layui-form-item">
                                <label for="UserPwd" class="layui-form-label">密码</label>

                                <div class="layui-input-block">
                                    <input type="password" name="UserPwd" lay-verify="required|userpwd"
                                           lay-reqtext="密码6-16位，由字母、数字组成！"
                                           maxlength="16" autocomplete="off" id="UserPwd"
                                           placeholder="密码6-16位，由字母、数字组成！"
                                           class="layui-input">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset4 layui-col-md4">
                            <div class="layui-row">
                                <div class="layui-col-xs8 layui-col-sm8 layui-col-md8">
                                    <div class="layui-form-item">
                                        <label for="UVerifyCode" class="layui-form-label">验证码</label>

                                        <div class="layui-input-block">
                                            <input type="text" name="UVerifyCode" lay-verify="required|number|code"
                                                   autocomplete="off" lay-reqtext="输入验证码" class="layui-input"
                                                   id="UVerifyCode" maxlength="4" placeholder="请输入验证码">
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-xs4 layui-col-sm4 layui-col-md4">
                                    <div id="cap" style="margin-left: 3px;"><?php echo captcha_img(); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset4 layui-col-md4">
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button id="btnsub" type="button" class="layui-btn" lay-submit="" lay-filter="sub">
                                        登陆
                                    </button>
                                    <a href="<?php echo url('/home/index/reg'); ?>" class="layui-btn layui-btn-danger">登记信息</a>
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
            usernum: [
                /^[0-9]{14}$/,
                '学号只能14数字！'
            ]
            , userpwd: [
                /^[a-zA-Z0-9_]{6,16}$/
                , '密码只能是字母、数字、下划线，6-16位！'
            ]
            , code: [
                /^[0-9]{1,4}$/
                , '验证码必须4位，且不能出现空格'
            ]
        });

        $(document).keypress(function (event) {
            if (event.which === 13) {
                $('#btnsub').click();
            }
        });

        //监听提交
        form.on('submit(sub)', function (data) {
            ajax_push('<?php echo url("/home/index/login"); ?>',data.field);
            $('#cap').children('img').click();
        });
    });
</script>
</body>
</html>