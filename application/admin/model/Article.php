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

        Article::event('afterInsert', function ($data) {
           echo '添加成功图片！';
        });
    }

}