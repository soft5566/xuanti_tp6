<?php /*a:1:{s:62:"C:\D\phpstudy_pro\WWW\xuanti_tp6\app\home\view\index\inst.html";i:1606229240;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta charset="utf-8">
    <title><?php echo htmlentities($datacfg[4]['con_value']); ?>选题系统操作说明页面</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <style>
        .txtcenter{
            text-align: center
        }
        img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>
<body>
<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-xs12 layui-col-sm12">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                <legend><?php echo htmlentities($datacfg[4]['con_value']); ?>选题系统操作说明</legend>
            </fieldset>

            <div style="padding: 20px; background-color: #F2F2F2;">
                <div class="layui-col-space15">
                    <div class="layui-card">
                        <blockquote class="layui-elem-quote">
                            <?php echo htmlentities($datacfg[1]['con_inst']); ?>：<span class="layui-badge"><?php echo htmlentities($datacfg[1]['con_value']); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo htmlentities($datacfg[2]['con_inst']); ?>：<span class="layui-badge"><?php echo htmlentities($datacfg[2]['con_value']); ?></span> &nbsp;&nbsp;&nbsp;&nbsp;
                        </blockquote>
                        <blockquote class="layui-elem-quote">
                            <p>
                                <?php echo htmlentities($datacfg[3]['con_value']); ?>：
                                <br>
                                <?php echo $datacfg[3]['con_inst']; ?>
                            </p>
                        </blockquote>
                    </div>
                </div>
            </div>
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                <legend style="text-align: center"><span
                        class="layui-btn layui-btn-radius layui-btn-danger">操作步骤</span>
                </legend>
            </fieldset>

            <div style="padding: 20px; background-color: #F2F2F2;">
                <div class="layui-col-space15">
                    <div class="layui-card">
                        <fieldset class="layui-elem-field">
                            <legend><h4><b>第一步：</b>点击<span class="layui-btn layui-btn-danger">登记信息</span>按钮。</h4>
                            </legend>
                            <div class="layui-field-box txtcenter" >
                                <img src="/static/images/1.png" alt="">
                            </div>
                        </fieldset>

                        <fieldset class="layui-elem-field">
                            <legend><h4><b>第二步：</b>登记基本信息，并设置密码，点击<span class="layui-btn">确定录入</span>按钮。</h4></legend>
                            <div class="layui-field-box txtcenter">
                                <img src="/static/images/2.png" alt="">
                            </div>
                        </fieldset>

                        <fieldset class="layui-elem-field">
                            <legend><h4><b>第三步：</b>输入学号和刚设置的密码，点击<span class="layui-btn">登陆</span>按钮。</h4></legend>
                            <div class="layui-field-box txtcenter">
                                <img src="/static/images/3.png" alt="">
                            </div>
                        </fieldset>

                        <fieldset class="layui-elem-field">
                            <legend><h4><b>第四步：</b>选择一个合心意的题目，点击<span class="layui-btn layui-btn-danger">确定提交选题</span>按钮确认。
                            </h4>
                            </legend>
                            <div class="layui-field-box txtcenter">
                                <img src="/static/images/4.png" alt="">
                            </div>
                        </fieldset>

                        <fieldset class="layui-elem-field">
                            <legend><h4><b>第五步：</b>选题结束，可查看选题结果。如果提示没有抢到，可以刷新选题页面，重新选题，否则不能再选！</h4>
                            </legend>
                            <div class="layui-field-box txtcenter">
                                <img src="/static/images/5.png" alt="">
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/static/layui/layui.js" charset="utf-8"></script>
</body>
</html>