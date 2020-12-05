<?php

namespace app\admin\controller;


use app\admin\model\ConfigModel;
use app\admin\model\CtitleModel;
use app\admin\model\ResultModel;
use app\BaseController;
use Think\Exception;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Title extends BaseController
{
    /**
     * 验证用户是否登陆
     */
    public function initialize()
    {
        if (!session('?uloginName'))
            redirect("/admin/index/index")->send();
    }

    /**
     * 显示选题首页
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $cnumMax = CtitleModel::max('c_Num');
        $spclass = Db::name('specility')->distinct(true)
            ->field('sp_Classes')->order('sp_Classes')->select();

        $sitename = getConfig();

        View::assign('datacfg', $sitename);
        View::assign('spclass', $spclass);
        View::assign('cnumMax', $cnumMax + 1);
        return View::fetch();
    }

    /**
     * 批量导入选题
     * @return \think\response\Json
     */
    function insertAllAction()
    {
        if (input('?post.allTitle')) $allTitle = input('post.allTitle');

        if (chk_empty($allTitle)) {
            return show_info(-1, '未接收到任何数据！');
        }

        $bool = 0;
        $count = 0;
        $allRecord = explode("\n", $allTitle);
        foreach ($allRecord as $item) {
            if (strlen(trim($item)) != 0) {
                $Record = explode("\t", $item);

                if (sizeof($Record) == 9) {
                    $condition['c_Num'] = $Record[0];
                    $condition['c_Title'] = $Record[1];
                    $condition['c_Tutor'] = $Record[2];
                    $condition['c_zhichen'] = $Record[3];
                    $condition['c_Phone'] = $Record[4];
                    $condition['c_People'] = $Record[5];
                    $condition['c_Left'] = $Record[6];
                    $condition['c_Class'] = $Record[7];
                    $condition['c_Design'] = $Record[8];

                    $tf = CtitleModel::create($condition);
                    if ($tf->isEmpty()) {
                        $bool += 1;
                    } else {
                        $count += 1;
                    }
                } else {
                    return show_info(-1, '数据没有按照格式：'
                        . '<br><br>【题号 题目名称 导师姓名 职称 手机 合作人数 可选人数 题目方向 题目类别】'
                        . '<br><br>的要求输入，不能批量导入！');
                }

//                如需要检查重复记录，启用下面代码
//                $result = $stuTable->where('c_Title="' . $Record[2] . '"')->find();
//                if ($result) {
//                    $info = '此题目，数据库中已经存在！';
//                    $url = 'javascript:history.back(-1);';
//                    $this->error($info, $url, 5);
//                } else {
//                    try {
//                        $stuTable->add($condition);
//                    } catch (Exception $e) {
//                        echo $e->getMessage();
////                        $url = 'javascript:history.back(-1);';
////                        $this->error('题目添加失败', $url, 50);
//                    }
//                }
            }
        }
        if ($bool == 0)
            return show_info(0, '批量添加成功！共成功：' . $count . ' 条记录！', '/admin/title/addall');
        else
            return show_info(-1, '题目批量添加失败！共失败：' . $count . ' 条记录！', '/admin/title/addall');
    }

    function insertAction()
    {
        if (input('?post.ctitle')) $titlename = input('post.ctitle');

        $condition['c_Num'] = input('post.titleid');
        $condition['c_Title'] = $titlename;
        $condition['c_Tutor'] = input('post.ctutor');
        $condition['c_zhichen'] = input('post.czhichen');
        $condition['c_Phone'] = input('post.cphone');
        $condition['c_People'] = input('post.cpeople');
        $condition['c_Left'] = input('post.cpeople');
        $condition['c_Class'] = input('post.cclass');
        $condition['c_Design'] = input('post.cdesign');

        if (chk_empty($condition)) {
            return show_info(-1, '未接收到任何数据！');
        }

        $find = CtitleModel::where('c_Title', '=', $titlename)->findOrEmpty();
        if (!$find->isEmpty()) {
            return show_info(0, '此题目，数据库中已经存在！', '/admin/title/index');
        } else {
            try {
                $add = CtitleModel::create($condition);
                if (!$add->isEmpty())
                    return show_info(0, '题目添加成功！', '/admin/title/index');
                else
                    return show_info(-1, '题目添加失败！');
            } catch (Exception $e) {
                return show_info(-1, '题目添加失败！异常！');
            }
        }
    }


    /**
     * 获取选题
     * @return false|string
     */
    public function getTitle()
    {
        if (input('?get.keys.act')) $src = input('get.keys.act');
        if (input('?get.keys.key')) $key = input('get.keys.key');

        if (input('?get.page')) $page = input('get.page');
        if (input('?get.limit')) $limit = input('get.limit');

        $sqlcount = "SELECT count(c_Id) as recodenum"
            . " FROM selt_ctitle";

        $sql = "SELECT *"
            . " FROM selt_ctitle"
            . " ORDER BY c_Tutor,c_Title"
            . " limit " . ($page - 1) * $limit . "," . $limit;

        if (isset($src)) {
            $k = trim($key);
            if (!empty($k)) {
                $keywords = explode(' ', $k);
                $str = '';
                foreach ($keywords as $value) {
                    $temp = trim($value);
                    $str .= "c_Title like '%" . $temp
                        . "%' OR c_Title like '%" . $temp
                        . "%' OR c_Tutor like '%" . $temp
                        . "%' OR c_zhichen like '%" . $temp
                        . "%' OR c_Phone like '%" . $temp
                        . "%' OR c_Class like '%" . $temp
                        . "%' OR c_Design like '%" . $temp . "%' OR ";
                }
                $str = substr($str, 0, -4);
                $sqlcount = "SELECT count(c_Id) as recodenum"
                    . " FROM selt_ctitle"
                    . " WHERE " . $str;

                $sql = "SELECT *"
                    . " FROM selt_ctitle"
                    . " WHERE " . $str
                    . " ORDER BY c_Tutor,c_Title"
                    . " limit " . ($page - 1) * $limit . "," . $limit;
            }
        }

        $resultcount = Db::query($sqlcount);
        // 总记录数
        $rowNum = $resultcount[0]['recodenum'];
        // 总数据
        $result = Db::query($sql);

        return getLayUITableJson($rowNum, $result);
    }

    /**
     * 修改选题
     * @return \think\response\Json
     */
    public function modifyAction()
    {
        if (input('?post.modifycid')) $condition['c_Id'] = input('post.modifycid');
        if (input('?post.modifytitleid')) $condition['c_Num'] = input('post.modifytitleid');
        if (input('?post.modifyctitle')) $condition['c_Title'] = input('post.modifyctitle');
        if (input('?post.modifyctutor')) $condition['c_Tutor'] = input('post.modifyctutor');
        if (input('?post.modifyczhichen')) $condition['c_zhichen'] = input('post.modifyczhichen');
        if (input('?post.modifycphone')) $condition['c_Phone'] = input('post.modifycphone');
        if (input('?post.modifycdesign')) $condition['c_Design'] = input('post.modifycdesign');
        if (input('?post.modifycclass')) $condition['c_Class'] = input('post.modifycclass');
        if (input('?post.modifycpeople')) $condition['c_People'] = input('post.modifycpeople');
        if (input('?post.modifycleft')) $condition['c_Left'] = input('post.modifycleft');

        if (chk_empty($condition)) {
            return show_info(-1, '未接收到任何信息！');
        }

        try {
            $result = CtitleModel::update($condition);

            if (!$result->isEmpty()) {
                return show_info(0, '题目修改成功！', '/admin/title/index');
            } else {
                return show_info(-1, '题目修改失败！');
            }
        } catch (Exception $e) {
            return show_info(-1, '题目修改失败！异常！');
        }
    }

    /**
     * 删除选题
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    function delete()
    {
        // 批量删除
        if (Request::isPost()) {
            if (input('?post.arrayid')) $str = input('post.arrayid');

            if (chk_empty($str)) {
                return show_info(-1, '未接收到任何数据！');
            }

            // 已选题学生id拿出来比较，选了题目的学生不能进行删除
            $rsdata = Db::table('selt_result')->field('c_Id')->select()->toArray();
            $seltitleok = array();
            foreach ($rsdata as $value) {
                array_push($seltitleok, $value['c_Id']);
            }

            $cidarr = explode(',', $str);
            if (!empty($rsdata)) {
                $res = array_diff($cidarr, $seltitleok);
                if (!empty($res)) {
                    $result = CtitleModel::where('c_Id', 'in', $res)->delete();
                    if ($result > 0) {
                        return show_info(0, '未被选的题目，批量删除成功！', '/admin/title/index');
                    } else {
                        return show_info(-1, '题目已被选，此处不能删除！<br><br>请删除选题结果后，方可删除对应的题目！'
                            , '/admin/title/index');
                    }
                } else {
                    return show_info(-1, '题目已被选，此处不能删除！<br><br>请删除选题结果后，方可删除对应的题目！'
                        , '/admin/title/index');
                }
            } else {
                $result = CtitleModel::where('c_Id', 'in', $cidarr)->delete();
                if ($result > 0) {
                    return show_info(0, '未被选的题目，批量删除成功！', '/admin/title/index');
                }
            }
        } elseif (Request::isGet()) {  // 删除单条记录
            if (input('?get.cid')) $cid = input('get.cid');

            if (chk_empty($cid)) {
                return show_info(-1, '未接收到任何数据！');
            }
            $rsdata = ResultModel::where('c_Id', '=', $cid)->findOrEmpty();
            if ($rsdata->isEmpty()) {
                $result = CtitleModel::where('c_Id', '=', $cid)->delete();
                if ($result > 0) {
                    return show_info(0, '题目删除成功！');
                } else {
                    return show_info(-1, '题目删除失败！');
                }
            } else {
                return show_info(-1, '此题已经被选，不能删除！');
            }
        } else {
            return show_info(-1, '非法请求');
        }
    }

    function search()
    {
        if (IS_POST) {
            $snum = trim(input('Titlenum'));
            $sname = trim(input('Titlename'));
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
                $this->redirect('Title/select', $arr, 0, '页面跳转中...');
            }
        }
    }

    /**
     * 显示批量导入选题页面
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    function addAll()
    {
        $sitename = getConfig();

        View::assign('datacfg', $sitename);
        return View::fetch('addall');
    }
}