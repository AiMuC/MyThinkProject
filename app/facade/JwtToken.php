<?php
/*
 * @Date: 2021-10-10 07:44:22
 * @LastEditors: AiMuC
 * @LastEditTime: 2021-10-10 07:54:17
 * @FilePath: /data/MyThinkProject/app/facade/JwtToken.php
 */

namespace app\facade;

use think\Facade;

/**
 * @description: JWT操作类
 * @method static string SetToken($data, $exp = 1800, $bef = 10) 设置JWTToken
 * @method static obect CheckToken($jwt) JwtToken
 */
class JwtToken extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\JwtToken';
    }
}
