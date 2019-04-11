<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 2019/3/26 0026
 * Time: 10:37
 */

namespace app\admin\model;

use think\Db;
use think\Model;

class Cate extends Model
{

    /**
     * 查找顶级栏目、并更新排序
     */
    public function catetree()
    {
        $cateres = $this->order('sort ace')->select();
        return $this->sort($cateres);
    }

    /***
     * 排序的方法  找出顶级栏目
     */
    public function sort($data, $pid = 0, $level = 0)
    {
        static $arr = array();
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {  //找出顶级栏目
                $v['level'] = $level;
                $arr[] = $v;
                $this->sort($data, $v['id'], $level + 1);  //递归
            }
        }
        return $arr;
    }

    /**
     * 删除栏目
     */
    public function delcate($data)
    {
        if (!empty($data)) {
            Db::name('cate')->delete($data);
            return 1;
        } else {
            return 2;
        }
    }

    /**
     * 删除子栏目
     */
    public function getchilrenid($cateid){
        $cateres=$this->select();
        return $this->_getchilrenid($cateres,$cateid);
    }

    /**
     * @param $cateres
     * @param $pid递归的方式删除分类
     */
    public function _getchilrenid($cateres,$cateid){
        static $arr=array();
        foreach ($cateres as $k => $v) {
            if($v['pid'] == $cateid){
                $arr[]=$v['id'];
                $this->_getchilrenid($cateres,$v['id']);
            }
        }
        return $arr;
    }

}