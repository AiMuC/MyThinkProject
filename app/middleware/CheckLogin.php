<?php

namespace app\middleware;

use app\common\JwtToken;
use think\facade\Request;

class CheckLogin extends JwtToken
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $JWt = new JwtToken;
        $checkResult = $JWt->CheckToken(Request::header('Access-Token'));
        $request->userData = $checkResult->data;
        return $next($request);
    }
}
