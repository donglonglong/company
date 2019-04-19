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

class Article extends Common
{
    /**
     * alias 起别名
     * @return \think\response\View
     *
     * @throws \think\exception\DbException
     */
    public function lst(){
//        $sql ='select ba.id,ba.title,ba.keywords,ba.`desc`,ba.author,ba.thumb,ba.content,ba.click,ba.zan,ba.rec,ba.time,bc.catename from bk_article as ba inner join  bk_cate as  bc on ba.cateid=bc.id ORDER BY ba.id ASC LIMIT 0,5';
//        $articles = Db::query($sql);
//        $articles = Db::name('article')->field('a.*,b.catename')->alias('a')->join('bk_cate b','a.cateid =b.id')->order('a.id desc')->paginate(5);
        $articles = Db::name('article')->alias('a')->join('bk_cate b','a.cateid=b.id')->field('a.*,b.catename')->where('zan',0)->order('a.id ace')->paginate(6);

//        dump($articles);exit();
        $this->assign('articles',$articles);
        return view();
    }


    /**
     * 通过控制器层对文章进行添加
     * @return \think\response\View|void
     */
//    public function add(){
//        if(request()->isPost()){
//            $data = input('post.');
////            dump($data);exit();
//            $article = new ArticleModel();
//           if($_FILES['thumb']['tmp_name']){
//               $file = request()->file('thumb');
//               $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
//               if($info){
//                    $thumb =(ROOT_PATH . 'public' . DS . 'uploads');
//                    $data['thumb'] =$thumb;
//               }
//           }
//           if($article->save($data)){
//               $this->success('添加文章成功',url('lst'));
//           }else{
//               $this->error('添加文章失败');
//           }
//            return;
//        }
//        $cate = new CateModel();
//        $cateres = $cate->catetree();
//        $this->assign('cateres', $cateres);
//        return view();
//    }

    /**
     * 使用模型层添加文章
     * @return \think\response\View|void
     */
    public function  add(){

        if(request()->isPost()){
            $data = input('post.');
            $validate = \think\Loader::validate('Article');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
//           dump($data);exit();
//            $add = Db::name('article')->insert($data);
//            if ($add) {
//                $this->success('添加成功！', url('lst'));
//            } else {
//                $this->error('添加栏目失败！');
//            }
            $article = new ArticleModel();
            if($article->save($data)){
               $this->success('添加文章成功',url('lst'));
           }else{
               $this->error('添加文章失败');
           }
            return;
        }
        $cate = new CateModel();
        $cateres = $cate->catetree();
        $this->assign('cateres', $cateres);
        return view();
    }

    public function edit($id){
        if(request()->isPost()){
            $data = input('post.');
            $art = new ArticleModel();
            $save = $art->isUpdate()->save($data);
//            $save =Db::name('article')->update(input('post.'));
            if($save){
                $this->success('修改成功！',url('lst'));
            }else{
                $this->error('修改失败！');
            }
            return;
        }

        $cate = new CateModel();
        $article =Db::name('article')->find($id);
        $cateres = $cate->catetree();
        $this->assign(array(
            'cateres'=>$cateres,
            'article' =>$article,
        ));
        return view();
    }

    public function del( ){
             if(ArticleModel::destroy(input('id'))){
                $this->success('删除成功',url('lst'));
            }else{
                $this->error('删除失败');
            }
    }


}