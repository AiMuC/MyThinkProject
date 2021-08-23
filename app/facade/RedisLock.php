<?php
/*
 * @Author: AiMuC
 * @Date: 2021-08-23 05:01:45
 * @LastEditTime: 2021-08-23 09:20:06
 * @LastEditors: AiMuC
 * @Description: Redis操作类门面
 * @FilePath: /html/app/facade/RedisLock.php
 * By:AiMuC
 */

namespace app\facade;

use think\Facade;

class RedisLock extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\RedisLock';
    }
}
