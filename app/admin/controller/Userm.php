<?php

namespace app\admin\controller;


use app\admin\model\ResultModel;
use app\admin\model\UmanagerModel;
use app\BaseController;
use Think\Exception;
use think\facade\Db;
use think\facade\View;

class Userm extends BaseController
{
    /**
     * 检查是否登陆
     */
    public function initialize()
    {
        if (!session('?uloginName'))
            redirect("/admin/index/index")->send();
    }

    /**
     * 显示所有用户
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $sitename = getConfig();

        View::assign('datacfg', $sitename);

        return View::fetch();
    }

    /**
     * 取得用户
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUser()
    {
        $result = UmanagerModel::order('uname')->select();

        $rowNum = count($result);

        return getLayUITableJson($rowNum, $result);
    }

    /**
     * 添加用户
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function addAction()
    {
        if (input('?post.username')) $data['uname'] = input('post.username');

        if (chk_empty($data)) {
            return show_info(-1, '未接受到提交的数据！');
        }

        $chkUser = UmanagerModel::where('uname="' . $data['uname'] . '"')->findOrEmpty();
        if (!$chkUser->isEmpty()) {
            return show_info(-1, '用户已经被注册！请修改用户名后重新添加！');
        } else {
            $data['upwd'] = md5(input('Pwd'));
            $data['uright'] = 0;
            try {
                UmanagerModel::create($data);
                return show_info(0, '用户添加成功！', '/admin/userm/index');
            } catch (Exception $e) {
                return show_info(-1, '用户添加失败！');
            }
        }
    }

    /**
     * 修改用户
     * @return \think\response\Json
     */
    public function modifyAction()
    {
        if (input('?post.modifyuid')) $data['uid'] = input('post.modifyuid');
        if (input('?post.modifyusername')) $data['uname'] = input('post.modifyusername');
        if (input('?post.modifyPwd')) $data['upwd'] = md5(input('post.modifyPwd'));

        if (chk_empty($data)) {
            return show_info(-1, '未接受到提交的数据！');
        }

        $data['uright'] = 0;
        try {
            $update = UmanagerModel::update($data);
            if (!$update->isEmpty()) {
                return show_info(0, '用户修改成功！');
            } else {
                return show_info(-1, '用户修改失败！');
            }
        } catch (Exception $e) {
            return show_info(-1, '用户修改异常！');
        }
    }

    /**
     * 删除用户
     * @return \think\response\Json
     */
    public function delete()
    {
        if (input('?post.uid')) $uid = input('post.uid');

        if (chk_empty($uid)) {
            return show_info(-1, '未接受到提交的数据！');
        }

        $current = UmanagerModel::where('uid=' . $uid)->findOrEmpty();

        if ($current->isEmpty()) {
            return show_info(-1, '用户未找到！');
        } else {
            if ($current['uid'] == session('uid') && $current['uname'] == session('uloginName')) {
                return show_info(-1, '当前登陆用户，不能删除！');
            } else {
                try {
                    $del = UmanagerModel::destroy($uid);
                    if ($del) {
                        return show_info(0, '用户删除成功！');
                    }
                } catch (Exception $e) {
                    return show_info(-1, '用户删除失败！');
                }
            }
        }
    }

    /**
     * 显示选题结果页面
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function viewtitle()
    {
        $sitename = getConfig();

        View::assign('datacfg', $sitename);

        return View::fetch();
    }

    /**
     * 显示选题结果数据
     * @return false|string
     */
    function getSelResult()
    {
        $sql = 'SELECT s_num,s_sex,s_name,sp_name,s_phone,s_email,c_num,c_title,c_tutor,c_zhichen,c_phone,r_order,r_id' .
            ' FROM selt_result AS r,selt_sinfo AS s,selt_ctitle AS c,selt_specility AS sp'
            . ' WHERE r.s_id=s.s_id AND r.c_id=c.c_id AND sp_id=s.s_sc ORDER BY r.s_id,r_order';
        $result = Db::query($sql);

        $rowNum = count($result);

        return getLayUITableJson($rowNum, $result);
    }

    /**
     * 删除单个选题结果，同时对应的原题库中对应的题目所剩人数增加1
     * @return \think\response\Json
     */
    function deleteTitle()
    {
        if (input('?post.rid')) $rid = input('post.rid');

        if (chk_empty($rid)) {
            return show_info(-1, '未接受到提交的数据！');
        }

        return $this->deleteT($rid, true);
    }

    /**
     * 批量删除选题
     * @return \think\response\Json
     */
    function deleteAllTitle()
    {
        $str = input('post.arrayid');
        $ridarr = explode(',', $str);
        $tf = false;
        foreach ($ridarr as $val) {
            $tf = $this->deleteT($val, false);
            if (!$tf) {
                break;
            }
        }
        if ($tf) {
            return show_info(0, '批量删除成功！', '/admin/userm/viewtitle');
        } else {
            return show_info(-1, '批量删除失败！');
        }
    }

    /**
     * 删除指定id
     * @param $rid
     * @param $all
     * @return bool|\think\response\Json
     */
    public function deleteT($rid, $all)
    {
        $selcid = ResultModel::where('r_Id=' . $rid)->findOrEmpty();

        $cid = $selcid['c_Id'];

        if (chk_empty($cid)) {
            return show_info(-1,'未接收到任何数据！');
        }

        $commit = false;
        // 启动事务
        Db::startTrans();
        try {
            Db::table('selt_result')->delete($rid);
            Db::table('selt_ctitle')->where('c_Id', $cid)->inc('c_Left')->update();
            // 提交事务
            Db::commit();
            $commit = true;
        } catch (Exception $e) {
            // 回滚事务
            Db::rollback();
        }

        if ($all) {
            if ($commit) {
                return show_info(0, '删除成功！');
            } else {
                return show_info(-1, '删除失败！');
            }
        } else {
            return $commit;
        }
    }
}