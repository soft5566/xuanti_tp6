<?php

namespace app\admin\controller;

use app\admin\model\ConfigModel;
use app\admin\model\ResultModel;
use app\BaseController;
use app\home\model\SinfoModel;
use Think\Exception;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Stu extends BaseController
{
    public function initialize()
    {
        if (!session('?uloginName'))
            redirect("/admin/index/index")->send();
    }

    /**
     * 学生信息首页
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $spname = Db::name('specility')->distinct(true)->order('sp_Name')->select();

        $sitename = getConfig();

        View::assign('spname', $spname);
        View::assign('datacfg', $sitename);

        return View::fetch();
    }

    /**
     * 批量导入学生信息
     * @return \think\response\Json
     */
    public function insertAllAction()
    {
        if (input('?post.allStu')) $allStu = input('post.allStu');

        if (chk_empty($allStu)) {
            return show_info(-1, '未接收到任何数据！');
        }

        $bool = 0;
        $allRecord = explode("\n", $allStu);
        foreach ($allRecord as $item) {
            if (strlen(trim($item)) != 0) {
                $Record = explode("\t", $item);

                if (sizeof($Record) == 3) {
                    $condition['s_Num'] = $Record[0];
                    $condition['s_Name'] = $Record[1];
                    $condition['s_SC'] = $Record[2];

                    $tf = SinfoModel::create($condition);
                    if ($tf->isEmpty()) {
                        $bool += 1;
                    }
                } else {
                    return show_info(-1, '数据没有按照格式：<br><br>【学号 姓名 专业号】<br><br>的要求输入，不能批量导入！');
                }
            }
        }
        if ($bool == 0)
            return show_info(0, '学生批量添加成功！', '/admin/stu/addAll');
        else
            return show_info(-1, '学生批量添加失败！');
    }

    /**
     * 添加单个学生
     * @return \think\response\Json
     */
    public function insertAction()
    {
        if (input('?post.InputNum')) $stuNum = input('post.InputNum');
        if (input('?post.InputName')) $stuName = input('post.InputName');

        if (chk_empty($stuNum) && chk_empty($stuName)) {
            return show_info(-1, '未接收到任何数据！');
        }

        $condition['s_Num'] = $stuNum;
        $condition['s_Name'] = $stuName;
        $condition['s_Sex'] = input('InputSex');
        $condition['s_Phone'] = input('InputPhone');
        $condition['s_Email'] = input('InputEmail');
        $condition['s_SC'] = input('InputSC');
        $condition['s_Datetime'] = date("Y-m-d H:i:s", time());

        $result = SinfoModel::where(array('s_Num' => $stuNum, 's_Name' => $stuName))->findOrEmpty();
        if (!$result->isEmpty()) {
            return show_info(-1, '学号：' . $stuNum . '<br/>姓名：' . $stuName . '<br/>已经存在！');
        } else {
            try {
                $res = SinfoModel::create($condition);
                if ($res->isEmpty()) {
                    return show_info(-1, '添加学生失败！');
                } else {
                    return show_info(0, '添加学生成功！', '/admin/stu/index');
                }
            } catch (Exception $e) {
                return show_info(-1, '添加学生异常！');
            }
        }
    }

    //取得学生信息
    public function getStu()
    {
        if (input('?get.page')) $page = input('get.page');
        if (input('?get.limit')) $limit = input('get.limit');

        $sqlcount = "SELECT count(s_Id) as recodenum"
            . " FROM selt_sinfo info"
            . " INNER JOIN selt_specility spec"
            . " ON info.s_SC=spec.sp_Id";
        $resultcount = Db::query($sqlcount);
        // 总记录数
        $rowNum = $resultcount[0]['recodenum'];

        $sql = "SELECT info.*,spec.sp_Name"
            . " FROM selt_sinfo info"
            . " INNER JOIN selt_specility spec"
            . " ON info.s_SC=spec.sp_Id"
            . " ORDER BY s_SC,s_Num"
            . " limit " . ($page - 1) * $limit . "," . $limit;
        // 总数据
        $result = Db::query($sql);

        return getLayUITableJson($rowNum, $result);
    }

    public function modifyAction()
    {
        if (input('?post.modifysid')) $sid = input('post.modifysid');

        if (chk_empty($sid)) {
            return show_info(-1, '未接收到任何数据！');
        }

        $condition['s_Id'] = $sid;
        $condition['s_Num'] = input('post.modifyInputNum');
        $condition['s_Name'] = input('post.mofifyInputName');
        $condition['s_Pwd'] = '';  // 重置密码
        $condition['s_Sex'] = input('post.modifyInputSex');
        $condition['s_Phone'] = input('post.modifyInputPhone');
        $condition['s_Email'] = input('post.modifyInputEmail');
        $condition['s_SC'] = input('post.modifyInputSC');
//        $condition['s_Datetime'] = date("Y-m-d H:i:s", time());

        try {
            $result = SinfoModel::update($condition);
            if (!$result->isEmpty()) {
                return show_info(0, '学生信息修改成功！', '/admin/stu/index');
            } else {
                return show_info(-1, '学生信息修改失败！');
            }
        } catch (Exception $e) {
            return show_info(-1, '学生信息修改失败！异常！' . $e->getMessage());
        }
    }

    /**
     * 删除选题，可以批量删除，但只能删除未选题的学生
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function delete()
    {
        // 批量删除
        if (Request::isPost()) {
            // 已选题学生id拿出来比较，选了题目的学生不能进行删除
            $rsdata = Db::table('selt_result')->field('s_Id')->select()->toArray();
            $seltitleok = array();
            foreach ($rsdata as $value) {
                array_push($seltitleok, $value['s_Id']);
            }

            if (input('?post.arrayid')) $str = input('post.arrayid');

            if (chk_empty($str)) {
                return show_info(-1, '未接受到提交的数据！');
            }

            // 接收到的ID字符串分解成单个id
            $sidarr = explode(',', $str);
            if (!empty($rsdata)) {
                $res = array_diff($sidarr, $seltitleok);
                if (!empty($res)) {
                    $result = SinfoModel::where('s_Id', 'in', $res)->delete();
                    if ($result > 0) {
                        return show_info(0, '未选题的学生，已经全部删除成功！', '/admin/stu/index');
                    } else {
                        return show_info(-1, '学生已选题，此处不能删除！<br><br>先删除选题结果后，方可删除对应的学生！'
                            , '/admin/stu/index');
                    }
                } else {
                    return show_info(-1, '学生已选题，此处不能删除！<br><br>先删除选题结果后，方可删除对应的学生！'
                        , '/admin/stu/index');
                }
            } else {
                $result = SinfoModel::where('s_Id', 'in', $sidarr)->delete();
                if ($result > 0) {
                    return show_info(0, '未选题的学生，已全部删除成功！', '/admin/stu/index');
                }
            }
        } elseif (Request::isGet()) {  // 删除单个记录
            if (input('?get.sid')) $sid = input('get.sid');

            if (chk_empty($sid)) {
                return show_info(-1, '未接受到提交的数据！');
            }

            $rsdata = ResultModel::where('s_Id=' . $sid)->findOrEmpty();
            if ($rsdata->isEmpty()) {
                $result = SinfoModel::where('s_id', '=', $sid)->delete();
                if ($result) {
                    return show_info(0, '学生删除成功！');
                }
            } else {
                return show_info(-1, '此学生已经选题，不能删除！');
            }
        } else {
            return show_info(-1, '非法请求！', '/admin/index/index');
        }
    }

    public function search()
    {
        if (IS_POST) {
            $snum = trim($_POST['stunum']);
            $sname = trim($_POST['stuname']);
            $arr = array();

            if ($snum != null && $snum != '') {
                $arr['sn'] = $snum;
            }
            if ($sname != null && $sname != '') {
                $arr['snm'] = $sname;
            }

            if (!empty($arr)) {
                $arr['act'] = 'srh';
                //重定向到New模块的Category操作
                $this->redirect('Stu/select', $arr, 0, '页面跳转中...');
            }
        }
    }

    /**
     * 显示批量导入页面
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function addAll()
    {
        $sitename = getConfig();

        View::assign('datacfg', $sitename);
        return View::fetch('addall');
    }
}