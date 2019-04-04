<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 2019/3/29 0029
 * Time: 11:15
 */

namespace app\admin\validate;
use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'name'  =>  'require|max:25|min:3',
        'password' =>  'require|max:32',
    ];

    protected $message=[
        'name.require'=>'管理员名称必须填写！',
        'name.min'=>'管理员名称不得小于3位数！',
        'name.unique'=>'管理员名称长度不得大于25位',
        'password.require'=>'管理员密码必须填写',
        'password.max'=>'管理员密码长度不得大于32位',
    ];
    protected $scene = [
        'add'  =>  ['name'=>'require','password'],
        'edit'  =>  ['name','password'],
    ];
}