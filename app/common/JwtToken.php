<?php
/*
 * @Author: AiMuC
 * @Date: 2021-08-21 11:17:39
 * @LastEditTime: 2021-08-23 11:57:12
 * @LastEditors: AiMuC
 * @Description: JWT Token验证类
 * @FilePath: /html/app/common/JwtToken.php
 * By:AiMuC
 */

namespace app\common;

use Exception;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use InvalidArgumentException;
use UnexpectedValueException;

class JwtToken extends JWT
{

    private $Key = '@.qq11TokenNekot11pp.@'; //定义JWT Key

    /**
     * @Description: 生成随机盐
     * @param {*} $lenght
     * @return {*}
     */
    public function RandomSalt($lenght = 2)
    {
        $bytes = random_bytes($lenght);
        return bin2hex($bytes);
    }

    /**
     * @Description: 设置JWT_Key
     * @param {*} $Key
     * @return {*}
     */
    public function SetKey($Key)
    {
        $this->Key = $Key;
    }

    /**
     * @Description: 获取JWT_Key
     * @param {*}
     * @return {*}
     */
    public function GetKey()
    {
        return $this->Key;
    }

    /**
     * @Description: 设置JWT_Token
     * @param {*} $data
     * @param {*} $exp default 1800 30分钟    2592000 30天
     * @param {*} $bef default 10
     * @return {*}
     */
    public function SetToken($data, $exp = 1800, $bef = 10)
    {
        $token = [
            'iat' => time(),
            'bef' => time() + $bef,
            'exp' => time() + $exp,
            'data' => $data
        ];
        return JWT::encode($token, $this->Key);
    }

    /**
     * @Description: 验证Token
     * @param {*} $jwt
     * @return {*}
     */
    public function CheckToken($jwt)
    {
        try {
            return JWT::decode($jwt, $this->Key, ['HS256']);
        } catch (SignatureInvalidException $e) { //校验JWT签名是否有效
            abort(response()->data(json_encode(['code' => 0, 'msg' => 'Token签名失效'], JSON_UNESCAPED_UNICODE)));
        } catch (ExpiredException $e) { //校验签名是否过期
            abort(response()->data(json_encode(['code' => 0, 'msg' => 'Token过期', 'data' => json_decode($e->getMessage())], JSON_UNESCAPED_UNICODE)));
        } catch (InvalidArgumentException $e) {
            abort(response()->data(json_encode(['code' => 0, 'msg' => 'JWT Key为空'], JSON_UNESCAPED_UNICODE)));
        } catch (UnexpectedValueException $e) {
            abort(response()->data(json_encode(['code' => 0, 'msg' => '提供的Token无效'], JSON_UNESCAPED_UNICODE)));
        } catch (BeforeValidException $e) {
            abort(response()->data(json_encode(['code' => 0, 'msg' => '您提供的Token值暂未生效'], JSON_UNESCAPED_UNICODE)));
        } catch (BeforeValidException $e) {
            abort(response()->data(json_encode(['code' => 0, 'msg' => 'Token时效异常'], JSON_UNESCAPED_UNICODE)));
        } catch (Exception $e) { //捕获系统错误
            abort(response()->data(json_encode(['code' => 0, 'msg' => $e->getMessage()], JSON_UNESCAPED_UNICODE)));
        }
    }
}
