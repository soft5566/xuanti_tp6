<?php

namespace app\admin\controller;

use app\admin\model\SpecilityModel;
use app\BaseController;
use Think\Exception;
use think\facade\Db;
use think\facade\View;

class Specility extends BaseController
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
     * 管理专业首页
     * @return string
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
     * 取得专业信息
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getSpecility()
    {
        $select = SpecilityModel::order('sp_Id')->select();

        $rowNum = count($select);

        return getLayUITableJson($rowNum, $select);
    }

    /**
     * 专业开启选题的开关
     * @return \think\response\Json
     */
    public function openorclose()
    {
        if (input('?post.spid')) $dt['sp_Id'] = input('post.spid');
        if (input('?post.isnot')) $oo = input('post.isnot');

        if (chk_empty($dt['sp_Id'])) {
            return show_info(-1, '未接受到提交的数据！');
        }

        $o = ($oo == 'true') ? 0 : 1;
        $dt['sp_Open'] = $o;

        try {
            $result = SpecilityModel::update($dt);
            if ($result) {
                if ($o == 0)
                    return show_info(0, '专业开放！');
                else
                    return show_info(0, '专业关闭！');
            } else {
                return show_info(-1, '专业开放失败！');
            }
        } catch (Exception $e) {
            return show_info(-1, '专业开放异常！');
        }
    }

    /**
     * 添加专业
     * @return string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        if (input('?post.data.spname')) $data['sp_Name'] = input('post.data.spname');
        if (input('?post.data.spclass')) $data['sp_Classes'] = input('post.data.spclass');

        if (chk_empty($data)) {
            return show_info(-1, '未接受到提交的数据！');
        }

        $select = SpecilityModel::where('sp_Name="' . $data['sp_Name'] . '"')->find();
        if ($select) {
            return show_info(-1, '专业：' . $data['sp_Name'] . ' 已经存在！');
        } else {
            try {
                $create = SpecilityModel::create($data);
                if ($create) {
                    return show_info(0, '专业添加成功！', '/admin/specility/index');
                } else {
                    return show_info(-1, '专业添加失败！');
                }
            } catch (Exception $e) {
                return show_info(-1, $e->getMessage());
            }
        }
    }

    /**
     * 批量添加专业
     * @return \think\response\Json
     * @throws \Exception
     */
    public function addAll()
    {
        if (input('?post.data.allspclass'))
            $spclass = input('post.data.allspclass');

        if (chk_empty($spclass)) {
            return show_info(-1, '未接受到提交的数据！');
        }

        $allRecord = explode("\n", $spclass);
        $allnum = count(array_filter($allRecord));

        $num = 0;
        foreach ($allRecord as $item) {
            if (strlen(trim($item)) != 0) {
                $Record = explode("\t", $item);
                if (count($Record) == 2) {
                    $list = ['sp_Name' => trim($Record[0]), 'sp_Classes' => trim($Record[1])];
                    SpecilityModel::create($list);
                    $num++;
                } else {
                    $laydata['code'] = 10;
                    $laydata['msg'] = '数据没有按照格式：<br><br>&nbsp;&nbsp;&nbsp;&nbsp;【专业名称 专业类别】<br><br>的要求输入，不能批量导入！';
                    return json($laydata);
                }
            }
        }

        if ($num == $allnum) {
            return show_info(0, '批量专业添加成功！共添加' . $num . '个专业！', '/admin/specility/index');
        } else {
            return show_info(-1, '专业添加失败！还有' . ($allnum - $num) . '个专业未添加成功！',
                '/admin/specility/index');
        }
    }


    /**
     * 修改专业
     * @return \think\response\Json
     */
    public function modifyAction()
    {
        if (input('?post.data.modifyspid')) $data['sp_Id'] = input('post.data.modifyspid');
        if (input('?post.data.modifyspname')) $data['sp_Name'] = input('post.data.modifyspname');
        if (input('?post.data.modifyspclass')) $data['sp_Classes'] = input('post.data.modifyspclass');

        if (chk_empty($data)) {
            return show_info(-1, '未接受到提交的数据！');
        }

        $sql = "SELECT sp_Id FROM selt_specility WHERE sp_Name='" . $data['sp_Name']
            . "' AND sp_Classes='" . $data['sp_Classes'] . "'";
        $select = Db::query($sql);
        if ($select) {
            return show_info(-1, '专业：【' . $data['sp_Name'] . '】<br>专业类别：【'
                . $data['sp_Classes'] . '】<br>已经存在！');
        } else {
            $result = SpecilityModel::update($data);
            if ($result) {
                return show_info(0, '专业修改成功！', '/admin/specility/index');
            } else {
                return show_info(-1, '数据没有修改，数据库拒绝更新操作！');
            }
        }
    }

    /**
     * 删除专业
     * @return \think\response\Json
     */
    public function delete()
    {
        if (input('?post.spid')) $spid = input('post.spid');

        if (chk_empty($spid))
            return show_info(-1, '未接受到任何数据！');

        $sql = 'SELECT * FROM selt_specility,selt_sinfo WHERE sp_Id="' . $spid . '" AND sp_id=s_sc';
        $select = Db::query($sql);
        if ($select) {
            return show_info(-1, '该专业下有学生，不能执行删除操作！'
                . '<br><br>请先删除该专业下的所有学生，方可删除此专业！');
        } else {
            $result = SpecilityModel::destroy($spid);
            if ($result) {
                return show_info(0, '删除成功！');
            } else {
                return show_info(-1, '删除失败！');
            }
        }
    }
}