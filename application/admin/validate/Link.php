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
        'sort' => 'require|integer', '排序不可为空!|排序数据不正确!',
    ];

    protected $msg = [
        'title.require' => '标题必填',
        'title.unique' => '标题不能重复',
        'desc.max'     => '名称最多不能超过25个字符',
        'url.number'   => '年龄必须是数字',
    ];

    protected   $scene = [
        'add'   =>  ['name'],
        'edit'  =>  ['name'],
    ];

}