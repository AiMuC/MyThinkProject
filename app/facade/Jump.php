<?php
/*
 * @Date: 2021-10-10 07:30:28
 * @LastEditors: AiMuC
 * @LastEditTime: 2021-10-10 07:50:35
 * @FilePath: /data/MyThinkProject/app/facade/Jump.php
 */

namespace app\facade;

use think\Facade;

/**
 * @description: 页面跳转类
 * @method static string success($msg = '', $url = '/index', $wait = '3') 成功跳转方法
 * @method static string error($msg = '', $url = '/index', $wait = '3') 失败跳转方法
 */
class Jump extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\Jump';
    }
}
