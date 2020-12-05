<?php /*a:1:{s:61:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\home\view\index\reg.html";i:1607157249;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta charset="utf-8">
    <title><?php echo htmlentities($datacfg[4]['con_value']); ?>选题系统学生注册页面</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
</head>
<body>
<div class="layui-container">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend><?php echo htmlentities($datacfg[4]['con_value']); ?>选题系统学生注册页面<a
                href="<?php echo url('/home/index/inst'); ?>" target="_blank"
                class="layui-btn layui-btn-danger layui-btn-radius layui-btn-xs">选题操作说明</a></legend>
    </fieldset>
    <div style="padding: 20px; background-color: #F2F2F2;">
        <div class="layui-col-space15">
            <div class="layui-card">
                <form class="layui-form">
                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset3 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">学号</label>

                                <div class="layui-input-block">
                                    <input type="text" name="InputNum" lay-reqtext="学号14位，由数字组成"
                                           lay-verify="required|number|InputNum" maxlength="14"
                                           autocomplete="off" class="layui-input" id="InputNum"
                                           value="<?php echo htmlentities(''); ?>" placeholder="学号14位，由数字组成">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset3 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">姓名</label>

                                <div class="layui-input-block">
                                    <input type="text" name="InputName" lay-reqtext="姓名只能是汉字，2-10个"
                                           lay-verify="required|InputName" maxlength="10"
                                           autocomplete="off" class="layui-input" id="InputName"
                                           placeholder="姓名只能是汉字，2-10个">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset3 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">密码</label>

                                <div class="layui-input-block">
                                    <input type="password" name="InputPwd" lay-verify="required|InputPwd"
                                           lay-reqtext="字母、数字、下划线组成，6-16位" maxlength="16" autocomplete="off"
                                           id="InputPwd" placeholder="字母、数字、下划线组成，6-16位"
                                           class="layui-input">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset3 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">确认密码</label>

                                <div class="layui-input-block">
                                    <input type="password" name="InputConPwd" lay-verify="required|InputConPwd"
                                           lay-reqtext="确认密码" maxlength="16" autocomplete="off" id="InputConPwd"
                                           placeholder="确认密码" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset3 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">性别</label>

                                <div class="layui-input-block">
                                    <input type="radio" name="InputSex" value="男" lay-reqtext="男" title="男" checked>
                                    <input type="radio" name="InputSex" value="女" lay-reqtext="女" title="女">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset3 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">电话</label>

                                <div class="layui-input-block">
                                    <input type="tel" name="InputPhone" lay-verify="required|phone|number"
                                           lay-reqtext="手机号" maxlength="11" autocomplete="off" id="InputPhone"
                                           placeholder="手机号" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset3 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">邮箱</label>

                                <div class="layui-input-block">
                                    <input type="email" name="InputEmail" lay-verify="required|email"
                                           lay-reqtext="填写能与导师联系的邮箱" maxlength="30"
                                           autocomplete="off" id="InputEmail"
                                           placeholder="填写能与导师联系的邮箱" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md-offset3 layui-col-md4">
                            <div class="layui-form-item">
                                <div id="btnsub" class="layui-input-block">
                                    <button id="sub_btn" type="button" class="layui-btn" lay-submit="" lay-filter="sub">
                                        确定录入
                                    </button>
                                    <a href="<?php echo url('/home/index/index'); ?>" class="layui-btn layui-btn-danger">回到登陆</a>
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
            InputNum: [
                /^[0-9]{14}$/
                , '学号14位，由数字组成'
            ]
            , InputName: [
                /^[\u4e00-\u9fa5]{2,10}$/
                , '姓名只能是汉字，2-10个'
            ]
            , InputPwd: [
                /^[a-zA-Z0-9_]{6,16}$/
                , '密码只能是字母、数字、下划线，6-16位'
            ]
            , InputConPwd: function (value, item) {
                var revalue = $('#InputPwd').val();
                if (value != revalue) {
                    return '两次输入的密码不一致';
                }
            }
        });

        // 检查该生专业是否开启了选题
        $("#InputPwd").focus(function () {
            var stuname = $("#InputName").val().replace(/\s/g, "");
            var stunum = $("#InputNum").val().replace(/\s/g, "");
            if (stuname !== "" && stunum !== "") {
                ajax_push('<?php echo url("/home/index/chkstu"); ?>', {'stunum': stunum, 'stuname': stuname});
            }
        });

        $(document).keypress(function (event) {
            if (event.which === 13) {
                $('#sub_btn').click();
            }
        });

        //监听提交
        form.on('submit(sub)', function (data) {
            ajax_push('<?php echo url("/home/index/regAction"); ?>', data.field)
        });
    });
</script>
</body>
</html>