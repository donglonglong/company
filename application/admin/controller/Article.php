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
//            dump($data);exit();
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

        $article =Db::name('article')->find($id);
        if(!$article){
            $this->error('文章不存在');
        }
        $this->assign('article',$article);



        $cate = new CateModel();
        $cates = $cate->find($id);
        $cateres = $cate->catetree();
        $this->assign(array(
            'cateres'=>$cateres,
            'cates' =>$cates,
        ));
        return view();
    }

    public function del(){

    }


}