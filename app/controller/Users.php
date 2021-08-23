<?php

namespace app\controller;

use app\facade\JwtToken;
use app\model\UserModel;
use app\validate\CheckInput;
use think\exception\ValidateException;
use think\facade\Cache;
use think\facade\Request;

class Users extends JwtToken
{
    private $Input_Data;

    /**
     * @Description: 构造函数获取页面输入输入
     */
    public function __construct()
    {
        $this->Input_Data = [
            'Refresh-Token' => Request::header('Refresh-Token', ''),
            'username' => Request::post('username', ''),
            'password' => Request::post('password', '')
        ];
    }

    /**
     * @Description: 刷新用户访问令牌
     */
    public function RefreshToken()
    {
        try {
            validate(CheckInput::class)
                ->scene('RefreshToken')
                ->check($this->Input_Data);
        } catch (ValidateException $e) {
            return json([
                'code' => 0,
                'msg' => $e->getError()
            ]);
        }
        //获取令牌验证结果
        if (is_object($checkResult = JwtToken::CheckToken($this->Input_Data['Refresh-Token']))) {
            //从缓存中获取令牌
            $cacheToken = Cache::get(md5($checkResult->data->username) . 'Salt');
            //判断缓存中是否存在令牌
            if (empty($cacheToken)) {
                //从数据库读取刷新令牌
                $SqlUser = UserModel::find($checkResult->data->username);
                //令牌是否失效 
                if ($SqlUser->salt == $checkResult->data->salt) {
                    //生成新的访问令牌
                    $AccessToken = JwtToken::SetToken(['id' => $checkResult->data->id, 'username' => $checkResult->data->username]);
                    return json([
                        'code' => 1,
                        'data' => $AccessToken
                    ]);
                } else {
                    return json(['code' => 0, 'msg' => 'Token已失效,请重新登入']);
                }
            } else {
                //判断缓存中的令牌与输入的是否一致
                if ($cacheToken == $checkResult->data->salt) {
                    //生成新的访问令牌
                    $AccessToken = JwtToken::SetToken(['id' => $checkResult->data->id, 'username' => $checkResult->data->username]);
                    return json([
                        'code' => 1,
                        'data' => $AccessToken
                    ]);
                } else {
                    return json(['code' => 0, 'msg' => 'Token已失效,请重新登入']);
                }
            }
        }
    }

    /**
     * @Description: 用户退出登入
     */
    public function UserLoginOut()
    {
        try {
            validate(CheckInput::class)
                ->scene('LoginOut')
                ->check($this->Input_Data);
        } catch (ValidateException $e) {
            return json([
                'code' => 0,
                'msg' => $e->getError()
            ]);
        }
        $Token = JwtToken::CheckToken($this->Input_Data['Refresh-Token']);
        if (is_object($Token)) {
            $SqlUser = UserModel::find($Token->data->username);
            $SqlUser->salt = null;
            Cache::delete(md5($Token->data->username) . 'Salt');
            if ($SqlUser->save()) {
                return json([
                    'code' => 1,
                    'msg' => '退出登入成功'
                ]);
            }
        } else {
            return json([
                'code' => 0,
                'msg' => 'Token已失效请重新登入'
            ]);
        }
    }

    /**
     * @Description: 用户登入
     */
    public function UserLogin()
    {
        try {
            validate(CheckInput::class)
                ->scene('login')
                ->check($this->Input_Data);
        } catch (ValidateException $e) {
            return json([
                'code' => 0,
                'msg' => $e->getError()
            ]);
        }
        if ($SqlUser = UserModel::find(Request::post('username'))) {
            if (password_verify(Request::post('password'), $SqlUser->password)) {
                $salt = JwtToken::RandomSalt();
                $User = [
                    'id' => $SqlUser->id,
                    'username' => $SqlUser->username,
                    'salt' => $salt
                ];
                $Access_Token = JwtToken::SetToken($User);
                $Refresh_Token = JwtToken::SetToken($User, 2592000);
                $SqlUser->salt = $salt;
                $SqlUser->save();
                Cache::set(md5($SqlUser->username) . 'Salt', $salt);
                return json([
                    'code' => 1,
                    'msg' => '登入成功',
                    'data' => [
                        'Access-Token' => $Access_Token,
                        'Refresh-Token' => $Refresh_Token
                    ]
                ]);
            } else {
                return json([
                    'code' => 0,
                    'msg' => '用户密码错误,请重新登入'
                ]);
            }
        } else {
            return json([
                'code' => 0,
                'msg' => '不存在该用户'
            ]);
        }
    }

    /**
     * @Description: 用户注册
     */
    public function UserReg()
    {
        try {
            validate(CheckInput::class)
                ->scene('Register')
                ->check($this->Input_Data);
        } catch (ValidateException $e) {
            return json([
                'code' => 0,
                'msg' => $e->getError()
            ]);
        }
        if (UserModel::find($this->Input_Data['username'])) {
            return json([
                'code' => 0,
                'msg' => '用户名已存在,换昵称一个注册吧'
            ]);
        } else {
            $Reg = new UserModel();
            $Reg->username = $this->Input_Data['username'];
            $Reg->password = password_hash($this->Input_Data['password'], PASSWORD_DEFAULT);
            $Reg->state = 1;
            if ($Reg->save()) {
                return json([
                    'code' => 1,
                    'msg' => '注册成功'
                ]);
            }
        }
    }
}
