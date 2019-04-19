<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 2019/3/26 0026
 * Time: 10:37
 */

namespace app\admin\controller;

use think\Db;
use app\admin\model\Conf as ConfModel;


class Conf extends Common
{

    /**
     * @return \think\response\View展示页面
     */
    public function lst()
    {
        $Conf = new ConfModel();

        if(request()->isPost()){

            $sorts = input('post.');
//            dump($sorts);exit();
            foreach ($sorts as $k => $v) {
                $Conf->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功！',url('lst'));
        }
        $Confs = Db::name('conf')->order('sort ace')->paginate(10);
        $this->assign('Confs', $Confs);
        return view();
    }
    /**
     * @return \think\response\View添加分类
     */
    public function add()
    {
        $conf = new ConfModel();
        if (request()->isPost()) {
            $data = input('post.');
            //做个验证如果时中文的 逗号  更换成英文的逗号
            $validate = \think\Loader::validate('Conf');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }

            if($data['values']){
                $data['values'] = str_replace('，',',',$data['values']);
            }
            $add = $conf->save($data);
            if ($add) {
                $this->success('添加配置成功！', url('lst'));
            } else {
                $this->error('添加配置失败！');
            }
        }
        return view();
    }
    /***
     * 修改分类
     */
    public function edit()
    {
        if(request()->isPost()){
            $data = input('post.');
            $validate = \think\Loader::validate('Conf');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            if($data['values']){
                $data['values']=str_replace('，', ',', $data['values']);
            }
            $Conf =new ConfModel();
            $save =$Conf->save($data,['id'=>$data['id']]);
            if($save!==false){
                $this->success('更新成功！',url('lst'));
            }else {
                $this->error('更新失败');
            }
        }

        $Confs =ConfModel::find(input('id'));
        $this->assign('Confs',$Confs);
        return view();
    }
    /**
     * 删除分类
     * @param $id
     */
    public function remove($id)
    {

       $num = Db::name('conf')->delete($id);
       if($num>0){
           $this->success('删除成功！',url('lst'));
       }else{
            $this->error('删除失败',url('lst'));
       }
    }

    public function  conf(){
        if(request()->isPost()){
            $data=input('post.');
            $formarr=array();
            foreach ($data as $k => $v) {
                $formarr[]=$k;
            }
            $_confarr=db('conf')->field('enname')->select();
            $confarr=array();
            foreach ($_confarr as $k => $v) {
                $confarr[]=$v['enname'];
            }
            $checkboxarr=array();
            foreach ($confarr as $k => $v) {
                if(!in_array($v, $formarr)){
                    $checkboxarr[]=$v;
                }
            }
            if($checkboxarr){
                foreach ($checkboxarr as $ke => $v) {
                    ConfModel::where('enname',$v)->update(['value'=>'']);
                }
            }
            if($data){

                foreach ($data as $k=>$v) {
                    ConfModel::where('enname',$k)->update(['value'=>$v]);
                }

                $this->success('修改配置成功！');

            }
            return;
        }
        $confres=ConfModel::order('sort desc')->select();
        $this->assign('confres',$confres);
        return view();
    }
}