<?php

use app\home\model\ConfigModel;
use app\home\model\SinfoModel;
use app\home\model\SpecilityModel;
use app\home\model\TimeModel;

/**
 * 取配置
 * @return \think\Collection
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\DbException
 * @throws \think\db\exception\ModelNotFoundException
 */
function getConfig()
{
    //查询所有的配置信息
    $datacfg = ConfigModel::select();
    return $datacfg;
}

/**
 * 取专业
 * @return mixed
 */
function getSpecility()
{
    $specility = SpecilityModel::field('sp_Id,sp_Name')->order('sp_Name')->select();
    return $specility;
}

/**
 * 取学生信息
 * @param $data
 * @return mixed
 */
function getSinfo($data)
{
    $sinfo = SinfoModel::where($data)->find();
    return $sinfo;
}

/**
 * 将数组转json格式
 * @param $rowNum
 * @param $data
 * @param int $code
 * @param string $msg
 * @return false|string
 */
function getLayUITableJson($rowNum, $data, $code = 0, $msg = '')
{
    $result = array(
        "code" => $code,
        "msg" => $msg,
        "count" => $rowNum,
        "data" => $data
    );
    return json($result);
}

/**
 * 取时间
 * @return \think\Collection
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\DbException
 * @throws \think\db\exception\ModelNotFoundException
 */
function getTime()
{
    $time = TimeModel::limit(0, 1)->select();
    return $time;
}

/**
 * 检查是否为空
 * @param $arr
 * @return bool|string
 */
function chk_empty($arr)
{
    $tf = false;
    $type = gettype($arr);
    switch ($type) {
        case 'array':
            foreach ($arr as $key => $value) {
                if (gettype($value) == 'array') {
                    foreach ($value as $k => $v) {
                        if (empty(trim($v))) {
                            $tf = true;
                            break 3;
                        }
                    }
                } else {
                    if (empty(trim($value))) {
                        $tf = true;
                        break 2;
                    }
                }
            }
            break;
        default:
            if (empty(trim($arr)))
                return true;
    }

    return $tf;
}

/**
 * 返回信息
 * @param $data
 * @return \think\response\Json
 */
function show_info($code, $info, $url = '')
{
    $laydata['code'] = $code;
    $laydata['msg'] = $info;
    $laydata['url'] = $url;
    return json($laydata);
}