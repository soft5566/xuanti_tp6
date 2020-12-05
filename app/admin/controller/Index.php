<?php

namespace app\admin\controller;

use app\admin\model\UmanagerModel;
use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    /**
     * 管理员登陆页面
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        // 获取配置
        $sitename = getConfig();

        View::assign('datacfg', $sitename);
        return View::fetch();
    }

    /**
     * 登陆操作
     * @return \think\response\Json
     */
    public function login()
    {
        if (input('?post.UserName')) $user['uname'] = input('post.UserName');
        if (input('?post.UserPwd')) $user['upwd'] = md5(input('post.UserPwd'));

        if (chk_empty($user)) {
            return show_info(-1, '获取数据失败！');
        }

        $result = UmanagerModel::where($user)->findOrEmpty();
        if ($result->isEmpty()) {
            return show_info(-1, '用户名或密码错误！');
        } else {
            session('uid', $result['uid']);
            session('uloginName', $result['uname']);

            return show_info(0, '登陆成功！','/admin/manager/index');
        }
    }
}
