<?php
/*
 * @Author: AiMuC
 * @Date: 2021-08-23 05:07:33
 * @LastEditTime: 2021-10-10 07:48:26
 * @LastEditors: AiMuC
 * @Description: 
 * @FilePath: /data/MyThinkProject/app/controller/Test.php
 * By:AiMuC
 */

namespace app\controller;

use app\facade\RedisLock;
use app\facade\Jump;
use think\facade\Cache;

class Test
{
    public function jump()
    {
        return Jump::success('aaa');
    }
    public function index()
    {
        return 1;
    }
    public function insert()
    {
        Cache::set('kc', 100);
        Cache::set('buy', 0);
    }
    public function buy()
    {
        if (RedisLock::Redis_Lock('qianggou')) {
            $buy = Cache::get('buy');
            $kc = Cache::get('kc');
            if ($buy < $kc) {
                Cache::inc('buy');
                RedisLock::Redis_unLock('qianggou');
                return json([
                    'code' => 1,
                    'msg' => '恭喜你抢到啦,赶快下单吧!'
                ]);
            } else {
                RedisLock::Redis_unLock('qianggou');
                return json([
                    'code' => 0,
                    'msg' => '来晚啦已经抢完啦~'
                ], 404);
            }
        } else {
            return json([
                'code' => 0,
                'msg' => '活动太火爆啦稍后再试吧!'
            ], 201);
        }
    }
}
