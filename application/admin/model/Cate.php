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

    public function catetree()
    {
        $cateres = $this->select();
        return $this->sort($cateres);
    }

    /***
     * 排序的方法
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

    /***
     * 修改栏目信息
     */
    public function saveadmin($data,$admins)
    {
        if(!$data['catename']){
            return 2;//栏目名称为空
        }
        if($data['type']){
            return 3; //栏目类型为空
        }

        $num =Db::name('cate')->where($admins)->update($data);
        if($num>0){
            return true;
        }
    }

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