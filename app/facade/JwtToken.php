<?php
/*
 * @Author: AiMuC
 * @Date: 2021-08-23 03:57:59
 * @LastEditTime: 2021-08-23 03:58:24
 * @LastEditors: AiMuC
 * @Description: 
 * @FilePath: /studytp6/app/facade/JwtToken.php
 * QQ:1446929313
 */

namespace app\facade;

use think\Facade;

class JwtToken extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\JwtToken';
    }
}
