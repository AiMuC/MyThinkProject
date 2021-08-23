<?php

namespace app\validate;

use think\Validate;

class CheckInput extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username' => 'require|max:6',
        'password' => 'require|max:30',
        'Refresh-Token' => 'require'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'username.require' => '用户名必须填写',
        'username.max'     => '名称最多不能超过6个字符',
        'password.require' => '密码必须填写',
        'password.max'     => '密码最多不能超过6个字符',
        'Refresh-Token.require' => 'Refresh-Token不能为空'
    ];

    protected $scene = [
        'login'  =>  ['username', 'password'],
        'Register'  =>  ['username', 'password'],
        'LoginOut' => ['Refresh-Token'],
        'RefreshToken' => ['Refresh-Token'],
    ];
}
