<?php

namespace app\home\controller;

use app\BaseController;
use think\captcha\facade\Captcha;
use Think\Exception;
use think\facade\Db;
use think\facade\View;

class Index extends BaseController
{
    /**
     * 显示登陆页
     * @return string
     */
    public function index()
    {
        //查询一条记录，得到一维数组
        $sel = getTime();
        //赋值给变量
        $starttime = $sel[0]['t_startTime'];
        $endtime = $sel[0]['t_endTime'];

        //获取服务器当前时间
        $nowtime = date("Y-m-d H:i:s");
        //获取配置信息
        $sitename = getConfig();
        //给模板变量赋值
        View::assign('datacfg', $sitename);
        //检查现在是否在选题时间内，是则显示页面与该方法同名的模板文件
        if (strtotime($nowtime) > strtotime($starttime) && strtotime($nowtime) < strtotime($endtime)) {
            //渲染模板
            return View::fetch();
        } else {
            //比开始时间早
            if (strtotime($nowtime) < strtotime($starttime)) {
                //给模板变量赋值
                View::assign('startdatetime', "选题未开始！请耐心等待！");
                View::assign('enddatetime', "");
            } else {  //比结束时间晚
                //给模板变量赋值
                View::assign('startdatetime', "");
                //给模板变量赋值
                View::assign('enddatetime', "选题结束，系统已关闭！");
            }
            View::assign('starttime', $starttime);
            View::assign('endtime', $endtime);
            //指定模板文件，渲染模板
            return View::fetch('timego');
        }
    }

    /**
     * 显示注册页
     * @return string
     */
    public function reg()
    {
        //查询一条记录，得到一维数组
        $sel = getTime();
        //赋值给变量
        $starttime = $sel[0]['t_startTime'];
        $endtime = $sel[0]['t_endTime'];

        //获取服务器当前时间
        $nowtime = date("Y-m-d H:i:s");
        //获取配置信息
        $sitename = getConfig();
        //给模板变量赋值
        View::assign('datacfg', $sitename);

        if (strtotime($nowtime) > strtotime($starttime) && strtotime($nowtime) < strtotime($endtime)) {
            //渲染模板
            return View::fetch();
        } else {
            //比开始时间早
            if (strtotime($nowtime) < strtotime($starttime)) {
                //给模板变量赋值
                View::assign('startdatetime', "选题未开始！请耐心等待！");
            } else {  //比结束时间晚
                //给模板变量赋值
                View::assign('enddatetime', "选题结束，系统已关闭！");
            }
            View::assign('starttime', $starttime);
            View::assign('endtime', $endtime);
            //指定模板文件，渲染模板
            return View::fetch('timego');
        }
    }

    /**
     * 查询该生所示专业是否允许选题
     * @param $snum
     * @param $sname
     * @return bool
     */
    function stuisopen($snum, $sname)
    {
        $sql = "SELECT sp_Open"
            . " FROM selt_sinfo AS s,selt_specility AS sp"
            . " WHERE s_Num='" . $snum . "' AND s_Name='" . $sname . "' AND s.s_SC=sp.sp_Id";
        $resultdata = Db::query($sql);
        if ($resultdata) {
            if ($resultdata[0]['sp_Open'] == 1) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 2;
        }
    }

    /**
     * 核实该生对应的专业是否开启选题
     * @return false|string
     */
    public function chkstu()
    {
        if (input('?post.stunum')) $snum = input('post.stunum');
        if (input('?post.stuname')) $sname = input('post.stuname');

        if (chk_empty($snum) && chk_empty($sname)) {
            return show_info(-1, '未接收到任何和数据！');
        }

        try {
            $tf = $this->stuisopen($snum, $sname);
            if ($tf == 1) {
                return show_info(-1, '请核实【本专业】【开始选题时间】！');
            } elseif ($tf == 0) {
                return show_info(0, '选题开始了！');
            } else {
                return show_info(-1, '无此学生信息！<br><br>'
                    . '1.学号或姓名有误，请检查！<br>'
                    . '2.你已定制或是校企合作班的同学！不需要在此系统选题！');
            }
        } catch (Exception $e) {
            return show_info(-1, '异常！');
        }
    }

    /**
     * 注册登记基本信息
     * @return \think\response\Json
     */
    public function regAction()
    {
        if (input('?post.InputNum')) $snum = input('post.InputNum');
        if (input('?post.InputName')) $sname = input('post.InputName');
        if (input('?post.InputPwd')) $spwd = input('post.InputPwd');
        if (input('?post.InputConPwd')) $sconpwd = input('post.InputConPwd');
        if (input('?post.InputSex')) $ssex = input('post.InputSex');
        if (input('?post.InputPhone')) $sphone = input('post.InputPhone');
        if (input('?post.InputEmail')) $semail = input('post.InputEmail');

        if (chk_empty($snum) && chk_empty($sname) && chk_empty($spwd) && chk_empty($sconpwd)
            && chk_empty($ssex) && chk_empty($sphone) && chk_empty($semail)) {
            return show_info(-1, '未接收到任何和数据！');
        }
        //检查密码是否一致
        if (!empty($spwd) && !empty($sconpwd) && $spwd != $sconpwd) {
            $laydata['code'] = 2;
            $laydata['msg'] = '密码和确认密码不一致！';
            return json($laydata);
        }

        //检查手机
        if (strlen($sphone) < 11) {
            $laydata['code'] = 2;
            $laydata['msg'] = '手机号长度不正确！';
            return json($laydata);
        }

        //创建数组，学号、姓名
        $data['s_Num'] = $snum;
        $data['s_Name'] = $sname;

        // 核实该生对应的专业是否开启选题========== start ========
        $tf = $this->stuisopen($snum, $sname);
        if ($tf) {
            return show_info(-1, '请核实【本专业】【开始选题时间】！');
        }
        // 核实该生对应的专业是否开启选题========== end ========

        //查找该生是否在学生信息表中存在
        $find = getSinfo($data);
        //如果没找到，则不是要求选题的人，非法选题人
        if (!$find) {
            return show_info(-1, '无此学生信息！<br><br>'
                . '1.学号或姓名有误，请检查！<br>'
                . '2.你已定制或是校企合作班的同学！不需要在此系统选题！');
        } else { //合法选题人
            if (!$find['s_Pwd']) { //密码为空，则同意注册
                $data['s_Id'] = $find['s_Id'];
                $data['s_Pwd'] = md5(sha1(md5(sha1($spwd))));
                $data['s_Sex'] = $ssex;
                $data['s_Phone'] = $sphone;
                $data['s_Email'] = $semail;
                $data['s_Datetime'] = gmdate('Y-m-d H:i:s', time() + 3600 * 8);

                //注册保存
                $update = $find->update($data);
                //注册成功
                if ($update) {
                    session('uid', $find['s_Id']);
                    session('stuNum', $snum);
                    return show_info(0, '信息录入成功！','/home/index/index');
                } else { //注册失败
                    return show_info(-1, '信息录入失败！');
                }
            } else { //密码不为空，则不同意注册
                return show_info(-1, '你已经登记过信息，请不要重复登记信息！');
            }
        }
    }

    /**
     * 选题操作说明
     * @return string
     */
    public function inst()
    {
        //获取配置信息
        $datacfg = getConfig();
        //给模板变量赋值
        View::assign('datacfg', $datacfg);
        //渲染模板
        return View::fetch();
    }

    /**
     * 验证码检测
     * @param $value
     * @return bool
     */
    public function check_verify($value)
    {
        if (!captcha_check($value)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 登陆
     * @return \think\response\Json
     */
    public function login()
    {
        if (input('?post.UserNum')) $unum = trim(input('post.UserNum'));
        if (input('?post.UserPwd')) $upwd = md5(sha1(md5(sha1(trim(input('post.UserPwd')))))); //加密
        if (input('?post.UVerifyCode')) $verifyCode = trim(input('post.UVerifyCode'));

        //如果学号、密码、验证码有一个未填写，就回退
        if (empty($unum) || empty($upwd) || empty($verifyCode)) {
            $laydata['code'] = 2;
            $laydata['msg'] = '学号、密码或验证码为空！';
            return json($laydata);
        }

        //组合sql语句，检查该生是否选题
        $sql = 'SELECT s_Num FROM selt_result AS r,selt_sinfo AS s WHERE s.s_Num='
            . $unum . ' AND s.s_Id=r.s_ID AND r.c_Id<>""';
        $sel = Db::query($sql);

        //查询该生的基本信息
        $select = getSinfo(['s_Num' => $unum]);
        try {
            //选题表中有记录，说明已经选题
            if ($sel) {
                //将该生对应的id和学号保存到session中
                session('uid', $select['s_Id']);
                session('stuNum', $unum);
                $laydata['code'] = 4;
                $laydata['msg'] = '该生已经选题！，请不要重复登录选题！';
                $laydata['url'] = '/home/manager/selresult';
                return json($laydata);
            } else {
                if ($verifyCode) { //验证码填了
                    if ($this->check_verify($verifyCode)) { //检查验证码，正确
                        try {
                            if ($select) { //该生基本信息存在
                                if ($select['s_Pwd'] == $upwd) { //核对密码正确
                                    //将该生对应的id和学号保存到session中
                                    session('uid', $select['s_Id']);
                                    session('stuNum', $unum);
                                    $laydata['code'] = 0;
                                    $laydata['msg'] = '登陆成功！';
                                    $laydata['url'] = '/home/manager/index';
                                    return json($laydata);
                                } else { //核对密码错误
                                    $laydata['code'] = 2;
                                    $laydata['msg'] = '密码不正确！';
                                    return json($laydata);
                                }
                            } else { //该生基本信息不存在
                                $laydata['code'] = 2;
                                $laydata['msg'] = '学号不存在！';
                                return json($laydata);
                            }
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    } else { //验证码错误
                        $laydata['code'] = 2;
                        $laydata['msg'] = '验证码不正确！';
                        return json($laydata);
                    }
                } else { //验证码未填写
                    $laydata['code'] = 2;
                    $laydata['msg'] = '请输入验证码！';
                    return json($laydata);
                }
            }
        } catch (\Exception $e) {
            $laydata['code'] = 2;
            $laydata['msg'] = '程序异常！请与管理员联系';
            return json($laydata);
        }
    }
}
