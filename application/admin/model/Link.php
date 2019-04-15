<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 2019/3/26 0026
 * Time: 10:37
 */

namespace app\admin\model;

use think\Model;

class Link extends Model
{
    public function getLink(){
        return $this::order('sort ace')->paginate(10,false);
    }




}