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

class Admin extends Model{
    public function addadmin($data){
        if(empty($data) || !is_array($data)){
        return false;
    }
        if($data['password']){
            $data['password']=md5($data['password']);
        }
        $adminData=array();
        $adminData['name']=$data['name'];
        $adminData['password']=$data['password'];
        if($this->save($adminData)){
            $groupAccess['uid']=$this->id;
            $groupAccess['group_id']=$data['group_id'];
            db('auth_group_access')->insert($groupAccess);
            return true;
        }else{
            return false;
        }

    }
    public function getadmin(){
//       return $this::where('id',1)->select();
//        $list = Db::name('user')->where('status',1)->paginate(10);
//        return $this::group('id')->paginate(5);  //分页
        return $this::group('id')->paginate(5,false);
//        return $this::getByname('222')->select();

    }

    public function saveadmin($data,$admins){
        if(!$data['name']){
            return 2;//管理员用户名为空
        }
        if(!$data['password1'] && $data['password2']){
            $data['password1']=$admins['password1'];
            $data['password2']=$admins['password2'];
        }else if(!$data['password1'] == $data['password2']){
            echo '两次密码输入不一致';
        }else{
            $data['password1']=md5($data['password1']);
            $data['password2']=md5($data['password2']);
        }
        return $this::update(['name'=>$data['name'],'password'=>$data['password1']],['id'=>$data['id']]);
    }

    public function deladmin($id){
        if($this::destroy($id)){
            return 1;
        }else{
            return 2;
        }
    }

    public function login($data){
     $admin = Admin::getbyname($data['name']);
     if($admin){
         if($admin['password'] == md5($data['password'])){
             session('id',$admin['id']);
             session('name',$admin['name']);
             return 2;//登录成功
         }else{
             return 3;//登录失败
         }
     }else{
         return 1;//用户不存在
     }

    }



}