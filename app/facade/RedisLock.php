<?php
/*
 * @Date: 2021-10-10 07:44:22
 * @LastEditors: AiMuC
 * @LastEditTime: 2021-10-10 07:52:23
 * @FilePath: /data/MyThinkProject/app/facade/RedisLock.php
 */

namespace app\facade;

use think\Facade;

/**
 * @description: Redis锁
 * @method static bool Redis_Lock($scene, $expire = 5, $retry = 5, $sleep = 1000) Redis操作上锁
 * @method static bool Redis_unLock($scene) redis操作解锁
 */
class RedisLock extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\RedisLock';
    }
}
