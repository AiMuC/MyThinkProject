<?php
/*
 * @Author: AiMuC
 * @Date: 2021-08-23 12:04:06
 * @LastEditTime: 2021-08-23 12:28:31
 * @LastEditors: AiMuC
 * @Description: 
 * @FilePath: /html/app/middleware.php
 * By:AiMuC
 */
// 全局中间件定义文件
return [
    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Session初始化
    \think\middleware\SessionInit::class,
    // 跨域请求支持
    \think\middleware\AllowCrossDomain::class,
    //限制接口请求频率
    \think\middleware\Throttle::class,
];
