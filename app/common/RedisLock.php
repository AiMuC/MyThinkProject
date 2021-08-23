<?php
/*
 * @Author: AiMuC
 * @Date: 2021-08-23 04:55:17
 * @LastEditTime: 2021-08-23 08:48:33
 * @LastEditors: AiMuC
 * @Description: Redis操作类
 * @FilePath: /html/app/common/RedisLock.php
 * By:AiMuC
 */

namespace app\common;

use think\cache\driver\Redis;

class RedisLock extends Redis
{
    private $Redis; //通过构造方法获取Redis操作对象

    private $LockId; //锁的ID

    /**
     * @Description: 构造方法创建Redis对象 获取handler
     */
    public function __construct()
    {
        $this->Redis = new Redis();
        $this->Redis = $this->Redis->handler();
    }

    /**
     * @Description: Redis锁
     * @param {*} $scene 场景名称
     * @param {*} $expire Default 5 Redis键过期时间
     * @param {*} $retry Default 5重试次数
     * @param {*} $sleep Default 500 重试等待时间
     * @return {*}
     */
    public function Redis_Lock($scene, $expire = 5, $retry = 5, $sleep = 1000): bool
    {
        $Redis = $this->Redis;
        while ($retry-- > 0) {
            $value = session_create_id(); //创建不重复的锁ID
            $Lock = $Redis->set($scene, $value, ["nx", "ex" => $expire]);
            if ($Lock) {
                $this->LockId[$scene] = $value;
                break;
            }
            usleep($sleep);
        }
        return $Lock;
    }

    /**
     * @Description: 删除Redis锁
     * @param {String} $scene 场景名称
     * @return {bool} 
     */
    public function Redis_unLock($scene)
    {
        $Redis = $this->Redis;
        $LockId = $this->LockId[$scene];
        //判断当前场景的锁是否存在
        if (isset($LockId)) {
            $value =  $Redis->get($scene);
            if ($value == $LockId) {
                return $Redis->del($scene); // 删除锁
            }
        }
    }
}
