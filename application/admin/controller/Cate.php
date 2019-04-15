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
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;


class Cate extends Common
{
    /***
     * @var array 前置操作  （用于先删除子分类）
     */
    protected $beforeActionList = [
//        'first',
//        'second' =>  ['except'=>'second'],
        'delsoncate' => ['only' => 'remove'],
    ];
    public function hello(){
        echo 'hello';
    }
    /**
     * @return \think\response\View展示页面
     */
    public function lst()
    {

        $cate=new CateModel();
        if(request()->isPost()){
            $sorts=input('post.');
            foreach ($sorts as $k => $v) {
                $cate->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功！',url('lst'));
            return;
        }
        $cateres=$cate->catetree();
        $this->assign('cateres',$cateres);
        return view();
    }
    /**
     * @return \think\response\View添加分类
     */
    public function add()
    {
        $cate = new CateModel();
        if (request()->isPost()) {
            $data = input('post.');
            $add = Db::name('cate')->insert($data);
            if ($add) {
                $this->success('添加成功！', url('lst'));
            } else {
                $this->error('添加栏目失败！');
            }
        }
        $cateres = $cate->catetree();
        $this->assign('cateres', $cateres);
        return view();
    }
    /***
     * 修改分类
     * @param $id
     * @return \think\response\View|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *
     */
    public function edit($id)
    {
        $cate = new CateModel;
        if(request()->isPost()){
            $data =input('post.');
            $save =$cate->save($data,['id'=>$data['id']]);
            if($save !== false){
                $this->success('修改栏目成功！',url('lst'));
            }else{
                $this->error('修改栏目失败');
            }
            return ;
        }
        $cates = $cate->find(input('id'));
        $cateres = $cate->catetree();
        $this->assign(array(
            'cateres'=>$cateres,
            'cates' =>$cates,
        ));
        return view();
    }
    /**
     * 删除分类
     * @param $id
     */
    public function remove($id)
    {
        if (!empty($id)) {
            $cateres = new CateModel();
            $delnum = $cateres->delcate($id);
            if ($delnum == '1') {
                $this->success('删除栏目成功！', url('lst'));
            } else {
                $this->error('删除栏目失败！');
            }
        } else {

        }
    }
    /**
     * 删除子栏目的id
     */
    public function delsoncate(){
        $cateid = input('id');
        $catemode = new CateModel();
        $sonids = $catemode->getchilrenid($cateid);   //所有子栏目
        $allcateid=$sonids;
        $allcateid[]=$cateid;

        foreach ($allcateid as $k=>$v) {
            $article=new ArticleModel;
            $article->where(array('cateid'=>$v))->delete();  //根据栏目删除文章
        }
        if($sonids){
        Db::name('cate')->delete($sonids,$cateid);
        }
    }
    /**
     * 退出登录
     */
    public function loginout()
    {
        session(null);
        $this->success('退出系统成功', url('login/login'));
    }

}