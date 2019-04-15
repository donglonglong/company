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

class Article extends Model
{
    public static function init()
    {
        Article::event('before_insert', function ($data) {  //用了事件  添加之前
//            echo  111;exit();

            if ($_FILES['thumb']['tmp_name']) {
                $file = request()->file('thumb');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    $thumb = ( DS . 'uploads'.'/'.$info->getSaveName());
                    $data['thumb'] = $thumb;
                }
            }
        });

        Article::event('before_update', function ($data) {  //用了事件  添加之前
//            echo  111;exit();
            if ($_FILES['thumb']['tmp_name']) {

                $arts=Article::find($data->id);
                $thumbpath=$_SERVER['DOCUMENT_ROOT'].$arts['thumb'];
//                dump($thumbpath);exit();
                if(file_exists($thumbpath)){
                    @unlink($thumbpath);
                }

                $file = request()->file('thumb');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    $thumb = ( DS . 'uploads'.'/'.$info->getSaveName());
                    $data['thumb'] = $thumb;
                }
            }
        });

        Article::event('before_delete', function ($data) {  //用了事件  添加之前

            $arts=Article::find($data->id);
            $thumbpath=$_SERVER['DOCUMENT_ROOT'].$arts['thumb'];
            if(file_exists($thumbpath)){
                @unlink($thumbpath);
            }

        });


    }

}