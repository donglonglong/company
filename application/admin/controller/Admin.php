<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 2019/3/26 0026
 * Time: 10:37
 */
namespace app\admin\controller;
use think\Db;
use think\Loader;


use app\admin\model\Admin as AdminModel;
class Admin extends Common{
    public function lst(){
//        $res = db('admin')->field('name','password')->select();  //查询多条数据
//        $res = db('admin')->field('name','password')->find(1);  //查询单条数据
//        $res = db('admin')->field('name','password')->where(array('name'=>555,'password'=>555))->select();  //查询单条数据
//        $ret=  Db::table('bk_admin')->select();
//          $ret= Db::name('admin')->select();
//          dump($ret);
//          exit();
//          $res = AdminModel::getbypassword('555');
//          $res =$admin->select();
//          foreach ($res as $key =>$value){
//              echo $value->password;
//              echo '</br>';
//          }
//          dump($res);
//          exit();
          $admin =new AdminModel;
          $res = $admin->getadmin();
          $this->assign('res',$res);
          return view();
    }

    public function add(){
        if(request()->isPost()){
            $data=[
                'name' =>input('name'),
                'password' =>md5(input('password')),
            ];
            $validate = Loader::validate('Admin');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());exit();
            }
            if(Db::name('admin')->insert($data)){
                echo '添加成功！';
            }else{
                echo '添加失败！';
            }
        }
//        if(request()->isPost()){ //判断是不是post提交
//            //执行添加
////           $count = Db::name('admin')->insert(input('post.'));
//            $admin =  new   AdminModel();
//           if($admin->addadmin(input('post.'))){
//             $this->success("添加成功",url('lst'));
//           }else{
//               $this->error("添加失败");
//           }
//            return;
//      }
        return view();
    }

    public function edit($id){
       if(request()->isPost()){
           $admins=db('admin')->find($id);

           if(request()->isPost()){
               $data=input('post.');

               $admin=new AdminModel();
               $savenum=$admin->saveadmin($data,$admins);
               if($savenum == '2'){
                   $this->error('管理员用户名不得为空！');
               }
               if($savenum !== false){
                   $this->success('修改成功！',url('lst'));
               }else{
                   $this->error('修改失败！');
               }
               return;
           }

           if(!$admins){
               $this->error('该管理员不存在');
           }
       }

        $admins =Db::name('admin')->field('id,name,password')->find($id);
        if(!$admins){
            $this->error('该管理员不存在！');
        }
        $this->assign('admins',$admins);
        return view();
    }

    public function remove($id){
        $admin=new AdminModel();
        $delnum=$admin->deladmin($id);
        if($delnum == '1'){
            $this->success('删除管理员成功！',url('lst'));
        }else{
            $this->error('删除管理员失败！');
        }
  }

    /**
     * 退出登录
     */
    public function loginout(){
       session(null);
       $this->success('退出系统成功',url('login/login'));
    }

}