<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 2019/3/26 0026
 * Time: 10:37
 */

namespace app\admin\controller;

use think\Db;
use app\admin\model\Link as LinkModel;


class Link extends Common
{

    /**
     * @return \think\response\View展示页面
     */
    public function lst()
    {
        $link = new LinkModel();

        if(request()->isPost()){

            $sorts = input('post.');
//            dump($sorts);exit();
            foreach ($sorts as $k => $v) {
                $link->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功！',url('lst'));
        }
        $links = $link->getLink();
        $this->assign('links', $links);
        return view();
    }
    /**
     * @return \think\response\View添加分类
     */
    public function add()
    {
        $link = new LinkModel();
        if (request()->isPost()) {
            $data = input('post.');
            $add = Db::name('link')->insert($data);
            if ($add) {
                $this->success('添加成功！', url('lst'));
            } else {
                $this->error('添加栏目失败！');
            }
        }
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
        $link = new LinkModel;
        if(request()->isPost()){
            $data = input('post.');
            $validate = \think\Loader::validate('Link');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            $save =$link->save($data,['id'=>$data['id']]);
            if($save !== false){
                $this->success('修改成功！',url('lst'));
            }else{
                $this->error('修改栏目失败');
            }
            return ;
        }
        $links = $link->find(input('id'));
        $this->assign('link',$links);

        return view();
    }
    /**
     * 删除分类
     * @param $id
     */
    public function remove($id)
    {
       $num = Db::name('link')->delete($id);
       if($num>0){
           $this->success('删除成功！');
       }else{
           $this->error('删除失败！');

       }
    }
}