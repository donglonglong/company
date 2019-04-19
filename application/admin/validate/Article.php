<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 2019/4/15 0015
 * Time: 14:43
 */
namespace app\admin\validate;
use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title'  => 'require|max:5',

    ];

    protected $msg = [
        'title.require' => '标题必填',

    ];
    protected $scene = [
        'add'   =>  ['name'],
    ];

}