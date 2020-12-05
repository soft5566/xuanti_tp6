<?php

namespace app\home\controller;

use app\admin\model\ResultModel;
use app\BaseController;
use think\Exception;
use think\facade\Db;
use think\facade\View;

class Manager extends BaseController
{
    public function initialize()
    {
        //检查用户是否登陆
        if (!session('?uid') || !session('?stuNum')) {
            redirect("/home/index/index")->send();
        }
    }

    public function index()
    {
        //当前登陆的学生id
        $sid = session('uid');

        //组合数组$data
        $data['s_Id'] = $sid;
        $data['s_Num'] = session('stuNum');
        $stufind = getSinfo($data);
        //给模板变量赋值
        View::assign('studata', $stufind);   //该生基本信息显示
        //获取配置信息
        $sitename = getConfig();
        //给模板变量赋值
        View::assign('datacfg', $sitename);
        return View::fetch();
    }

    public function selresult()
    {
        //当前登陆的学生id
        $sid = session('uid');

        //获取配置信息
        $sitename = getConfig();

        //给模板变量赋值
        View::assign('datacfg', $sitename);

        //渲染模板
        return View::fetch();
    }

    /**
     * 获取选题结果
     */
    public function getResultData()
    {
        //当前登陆的学生id
        $sid = session('uid');
        //所有选题记录
        $sql = "SELECT s.s_id,s_Num,s_Name,sp_Name,s_Phone,s_Email,c_Num,c_Title,c_Tutor,r_Order"
            . " FROM selt_sinfo AS s,selt_result AS r,selt_ctitle AS c,selt_specility AS sp"
            . " WHERE s.s_Id=r.s_Id AND c.c_Id=r.c_Id AND sp.sp_Id=s.s_SC ORDER BY c_Title DESC";
        $resultdata = Db::query($sql);

        $MyResultdata = array();
        $data = array();
        foreach ($resultdata as $key => $value) {
            $value['c_Tutor'] = '***';
            $value['s_Phone'] = '***';
            $value['s_Email'] = '***';
            if ($value['s_id'] == $sid) {
                $MyResultdata[] = $value;
            } else {
                $data[] = $value;
            }
        }

        //合并两个数组
        $dataAll = array_merge($MyResultdata, $data);
        //计算选题数量
        $rowNum = count($dataAll);

        //调用对象中的方法，将数组转json格式
        return getLayUITableJson($rowNum, $dataAll);
    }

    /**
     * 获取选题
     * @return false|string
     */
    public function getData()
    {
        if (session('?uid')) {
            //当前登陆的学生id
            $sid = session('uid');

            //组合sql语句
            $sql = 'SELECT c_Id,c_Num,c_Title,c_People,c_Left,c_Class,c_Design'
                . ' FROM selt_specility,selt_sinfo,selt_ctitle'
                . ' WHERE s_Id=' . $sid . ' AND sp_id=s_sc AND sp_Classes=c_Class AND c_Left>0'
                . ' ORDER BY c_Title';
            //查询当前学生所在的专业类别
            $select = Db::query($sql);

            //计算题目数量
            $rowNum = count($select);

            //调用对象中的方法，将数组转json格式
            return getLayUITableJson($rowNum, $select);
        } else {
            //计算题目数量
            $rowNum = 0;
            //调用对象中的方法，将数组转json格式
            return getLayUITableJson($rowNum, []);
        }
    }

    // 检查是否注册
    public function chkreg($sid, $stunum)
    {
        //组合sql语句
        $sql = 'SELECT s_Pwd,s_Phone,s_Email'
            . ' FROM selt_sinfo'
            . ' WHERE s_Id=' . $sid . ' AND s_Num="' . $stunum . '"';
        //查询当前学生是否登记基本信息
        $select = Db::query($sql);
        if (empty($select[0]['s_Pwd']) || empty($select[0]['s_Phone']) || empty($select[0]['s_Email']))
            return false;
        else
            return true;
    }

    /**
     * 保存选题
     * @return \think\response\Json
     */
    public function selTitleAction()
    {
        if (session('?uid') && session('?stuNum')) {
            $sid = session('uid');
            $stunum = session('stuNum');
        } else
            redirect("/home/index/index")->send();

        // 检查是否注册
        if ($this->chkreg($sid, $stunum)) {
            //表单提交过来的选题id
            $cid = input('post.titid');
            //创建数组$data，将学生的id放入数组中
            $data['s_Id'] = $sid;

            //查询当前登陆的学生是否已经选题，到result表中查找
            $chksel = ResultModel::where($data)->findOrEmpty();
            //如果查询成功，则有记录，说明已经选题了
            if (!$chksel->isEmpty()) {
                return show_info(0, '该生的选题【已经提交】！<br><br>不能重复提交！', '/home/manager/selresult');
            } else { //选题结果表中没有记录，说明之前没有选题哦
                //将选题id数组$data中
                $data['c_Id'] = $cid;
                //选题时间放入数组$data中
                $data['r_Order'] = gmdate('Y-m-d H:i:s', time() + 3600 * 8);

                // 启动事务
                Db::startTrans();
                try {
                    $titleft = Db::name('ctitle')->field('c_Left')->where('c_Id', '=', $cid)
                        ->lock(true)->findOrEmpty();

                    //大于0，说明该题可以选
                    if ($titleft['c_Left'] > 0) {
                        //该题所剩人数减 1
                        $titmin = Db::table('selt_ctitle')->where('c_Id', '=', $cid)->dec('c_Left')
                            ->update();
                        //将选题结果数组$data存入结果表中
                        $resultadd = ResultModel::create($data);

                        //减1和存入都成功，说明选题成功，抢到了^_^
                        if ($titmin && !$resultadd->isEmpty()) {
                            // 提交事务
                            Db::commit();

                            return show_info(0, '抢到啦！耶！！^_^', '/home/manager/selresult');
                        } else {
                            // 回滚事务
                            Db::rollback();

                            return show_info(-1, '选题失败！', '/home/manager/index');
                        }
                    } else {
                        return show_info(-1, '该题已被别的同学抢走！请继续选题！！', '/home/manager/index');
                    }

                } catch (Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return show_info(-1, '选题失败，出现异常！' . $e->getMessage());
                }
            }
        } else {
            return show_info(-1, '请先登记个人信息，方便与导师联系！');
        }
    }
}
