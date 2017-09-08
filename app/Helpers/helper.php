<?php

/**
 * 自定义url路径规则
 * @param null $path
 * @param array $parameters
 * @param null $secure
 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
 */
function url_path($path = null, $parameters = [], $secure = null)
{
    return url($path, $parameters, $secure);
}

/**
 * 获取后台管理模块url路径 不需要加模块前缀
 * @param null $path
 * @param array $parameters
 * @param null $secure
 */
function get_admin_url($path = null, $parameters = [], $secure = null)
{
    $domain = env('ADMIN_DOMAIN', '');
    $prefix = env('ADMIN_MODULE_PREFIX', '');

    $path = empty($prefix) ? $path : $prefix . '/' . $path;
    $path = empty($domain) ? $path : $domain . '/' . $path;

    return url($path, $parameters, $secure);
}

if (!function_exists('get_value')){
    /**
     * 判断数组或对象中是否存在某个属性
     * @param $item
     * @param $key
     * @param null $default
     * @return bool|mixed|null
     */
    function get_value($item, $key, $default = null) {

        if (is_object($item)) {
            if (property_exists($item, $key)) {
                return $item->$key;
            }
        }
        if (is_array($item)) {
            if (isset($item[$key])) {
                return $item[$key];
            }
        }
        if ($default !== null) {
            return $default;
        }
        return false;
    }
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @return array
 * @author 鬼国二少 <guiguoershao@163.com>
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author 鬼国二少 <guiguoershao@163.com>
 */
function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
    if(is_array($tree)) {
        $refer = array();
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if(isset($reffer[$child])){
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby='asc');
    }
    return $list;
}

/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 * @author 鬼国二少 <guiguoershao@163.com>
 */
function list_sort_by($list, $field, $sortby='asc') {
    if(is_array($list)){
        $refer = $resultSet = array();
        foreach ($list as $i => $data)
            $refer[$i] = &$data[$field];
        switch ($sortby) {
            case 'asc': // 正向排序
                asort($refer);
                break;
            case 'desc':// 逆向排序
                arsort($refer);
                break;
            case 'nat': // 自然排序
                natcasesort($refer);
                break;
        }
        foreach ( $refer as $key=> $val)
            $resultSet[] = &$list[$key];
        return $resultSet;
    }
    return false;
}



if (!function_exists('date_formats')) {
    /**
     * 时间戳格式化
     * @param $time
     * @param string $format
     * @return false|null|string
     */
    function date_formats($time, $format = 'Y-m-d H:i:s')
    {
        if (is_numeric($time)) {
            return empty($time) ? null : date($format, $time);
        }

        return $time;
    }
}

/**
 * 根据身份证号获取省份
 * @param $id
 * @return mixed
 */
function get_province_by_id($id){
    if (empty($id)) {
        return '其他';
    }
    //截取前两位数
    $index = substr($id,0,2);
    $area = array(
        11 => "北京",
        12 => "天津",
        13 => "河北",
        14 => "山西",
        15 => "内蒙古",
        21 => "辽宁",
        22 => "吉林",
        23 => "黑龙江",
        31 => "上海",
        32 => "江苏",
        33 => "浙江",
        34 => "安徽",
        35 => "福建",
        36 => "江西",
        37 => "山东",
        41 => "河南",
        42 => "湖北",
        43 => "湖南",
        44 => "广东",
        45 => "广西",
        46 => "海南",
        50 => "重庆",
        51 => "四川",
        52 => "贵州",
        53 => "云南",
        54 => "西藏",
        61 => "陕西",
        62 => "甘肃",
        63 => "青海",
        64 => "宁夏",
        65 => "新疆",
        71 => "台湾",
        81 => "香港",
        82 => "澳门",
        91 => "国外"
    );
    return isset($area[$index]) ? $area[$index] : '其他';
}

/**
 * 根据身份证号获取年龄
 * @param $id
 * @return float|string
 */
function get_age_by_id($id)
{
    //过了这年的生日才算多了1周岁
    if(empty($id)) {
        return 0;
    }

    if (strlen($id) != 18 || strlen($id) != 15) {
        return 0;
    }

    $date = strtotime(substr($id,6,8));

    //获得出生年月日的时间戳
    $today=strtotime('today');

    //获得今日的时间戳
    $diff = floor(($today-$date)/86400/365);
    //得到两个日期相差的大体年数

    //strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
    $age = strtotime(substr($id,6,8).' +'.$diff.'years')>$today?($diff+1):$diff;

    return (int)$age;
}