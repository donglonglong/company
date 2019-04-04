<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 2019/4/1 0001
 * Time: 14:57
 */
namespace app\admin\controller;
use think\Db;
use think\Controller;
use app\admin\model\Admin;
//use app\admin\model\Admin;

class Login extends Controller
{
    public function login(){
        if(request()->isPost()){
            $admin = new Admin();
            $num = $admin->login(input('post.'));
            if($num==1){
                $this->error('用户不存在！');
            }else if ($num==2){
                $this->success('登录成功！','admin/lst');
            }else if($num==3){
                $this->error('用户名或密码错误','login');
            }
        }
        return view();
    }


}