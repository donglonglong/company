<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 2019/4/15 0015
 * Time: 10:14
 */

namespace app\admin\validate;
use think\Validate;


class Link extends Validate
{
    protected $rule = [
        'title'  => 'require|max:25',
        'desc'   => 'require|max:25',
        'url' => 'email',
        'sort' => 'number|between:1,120',
    ];

}