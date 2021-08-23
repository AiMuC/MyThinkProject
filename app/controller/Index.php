<?php

namespace app\controller;

use app\middleware\CheckLogin;
use think\Request;

class Index
{
    protected $middleware = [CheckLogin::class];
    public function index(Request $request)
    {
        print_r($request->userData);
    }
}
