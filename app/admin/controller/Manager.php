<?php

namespace app\admin\controller;

use app\admin\model\ConfigModel;
use app\admin\model\TimeModel;
use app\BaseController;
use Think\Exception;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Manager extends BaseController
{
    /**
     * 检查是否登陆
     * @return \think\response\Redirect|void
     */
    public function initialize()
    {
        if (!session('?uloginName'))
            redirect("/admin/index/index")->send();
    }

    /**
     * 后台首页
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        // 获取配置
        $sitename = getConfig();
        for ($i = 0; $i < count($sitename); $i++) {
            $sitename[$i]['con_inst'] = trim(str_ireplace("<br>", "\n", $sitename[$i]['con_inst']));
        }

        View::assign('datacfg', $sitename);
        return View::fetch();
    }

    /**
     * 登出
     * @return \think\response\Json
     */
    public function logout()
    {
        if (Request::isPost()) {
            session('uloginName', null);

            return show_info(0, '登出成功！', '/admin/index/index');
        }
    }

    /**
     * 设置时间
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function time()
    {
        $result = getTime();
        $sitename = getConfig();

        View::assign('datacfg', $sitename);
        View::assign('result', $result);
        return View::fetch();
    }

    /**
     * 修改选题时间
     * @return \think\response\Json
     */
    public function timeSave()
    {
        if (input('?post.tid')) $data['t_Id'] = input('post.tid');
        if (input('?post.startTime')) $data['t_startTime'] = input('post.startTime');
        if (input('?post.endTime')) $data['t_endTime'] = input('post.endTime');

        if (chk_empty($data)) {
            return show_info(-1, '未接受到任何数据！');
        }

        $sdate = strtotime($data['t_startTime']);
        $edate = strtotime($data['t_endTime']);
        if ($sdate >= $edate) {
            return show_info(-1, '【开始时间】不能大于或等于【结束时间】！');
        } else {
            $update = TimeModel::update($data);
            if ($update->isEmpty()) {
                return show_info(-1, '时间设置未修改！');
            } else {
                return show_info(0, '时间设置成功！', '/admin/manager/time');
            }
        }
    }

    /**
     * 修改配置
     * @return \think\response\Json
     */
    function modifyAction()
    {
        if (input('?post.cfg_numofpage_id')) $pagedata['con_id'] = input('post.cfg_numofpage_id');
        if (input('?post.cfg_numofpage_key')) $pagedata['con_key'] = input('post.cfg_numofpage_key');
        if (input('?post.cfg_numofpage_value')) $pagedata['con_value'] = input('post.cfg_numofpage_value');
        if (input('?post.cfg_numofpage_inst')) $pagedata['con_inst'] = input('post.cfg_numofpage_inst');

        if (input('?post.cfg_qq_id')) $qqdata['con_id'] = input('post.cfg_qq_id');
        if (input('?post.cfg_qq_key')) $qqdata['con_key'] = input('post.cfg_qq_key');
        if (input('?post.cfg_qq_value')) $qqdata['con_value'] = input('post.cfg_qq_value');
        if (input('?post.cfg_qq_inst')) $qqdata['con_inst'] = input('post.cfg_qq_inst');

        if (input('?post.cfg_phone_id')) $phonedata['con_id'] = input('post.cfg_phone_id');
        if (input('?post.cfg_phone_key')) $phonedata['con_key'] = input('post.cfg_phone_key');
        if (input('?post.cfg_phone_value')) $phonedata['con_value'] = input('post.cfg_phone_value');
        if (input('?post.cfg_phone_inst')) $phonedata['con_inst'] = input('post.cfg_phone_inst');

        if (input('?post.cfg_info_id')) $infodata['con_id'] = input('post.cfg_info_id');
        if (input('?post.cfg_info_key')) $infodata['con_key'] = input('post.cfg_info_key');
        if (input('?post.cfg_info_value')) $infodata['con_value'] = input('post.cfg_info_value');
        if (input('?post.cfg_info_inst'))
            $infodata['con_inst'] = str_replace("\n", "<br>", input('post.cfg_info_inst'));

        if (input('?post.cfg_sitename_id')) $sitenamedata['con_id'] = input('post.cfg_sitename_id');
        if (input('?post.cfg_sitename_key')) $sitenamedata['con_key'] = input('post.cfg_sitename_key');
        if (input('?post.cfg_sitename_value')) $sitenamedata['con_value'] = input('post.cfg_sitename_value');
        if (input('?post.cfg_sitename_inst')) $sitenamedata['con_inst'] = input('post.cfg_sitename_inst');

        if (chk_empty($pagedata) || chk_empty($qqdata) || chk_empty($phonedata)
            || chk_empty($infodata) || chk_empty($sitenamedata)) {
            return show_info(-1, '没有接受到数据！');
        }

        try {
            $page = ConfigModel::update($pagedata);
            $phone = ConfigModel::update($phonedata);
            $qq = ConfigModel::update($qqdata);
            $info = ConfigModel::update($infodata);
            $sitename = ConfigModel::update($sitenamedata);

            if (!$page->isEmpty() && !$phone->isEmpty() && !$qq->isEmpty() && !$info->isEmpty()
                && !$sitename->isEmpty()) {
                return show_info(0, '系统参数设置成功！', '/admin/manager/index');
            } else {
                return show_info(-1, '系统参数设置失败！');
            }
        } catch (Exception $e) {
            return show_info(-1, 'SQL语句出错，系统参数设置未修改！');
        }
    }

    /**
     * 清除学号、姓名、题目等等中的空格
     * @return \think\response\Json
     */
    public function clrspc()
    {
        $sql1 = "UPDATE selt_sinfo SET s_Num=replace(s_Num,' ' ,''),s_Name=replace(s_Name,' ' ,'')";
        $sql2 = "UPDATE selt_ctitle SET c_Tutor=replace(c_Tutor,' ' ,''),c_Title=replace(c_Title,' ' ,''),c_Class=replace(c_Class,' ' ,''),c_Phone=replace(c_Phone,' ' ,''),c_zhichen=replace(c_zhichen,' ' ,'')";
        Db::query($sql1);
        Db::query($sql2);
        return show_info(0, '清除空格成功！');
    }
}