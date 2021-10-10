<?php
/*
 * @Date: 2021-10-10 07:14:51
 * @LastEditors: AiMuC
 * @LastEditTime: 2021-10-10 07:29:20
 * @FilePath: /tp/app/common/Jump.php
 */

namespace app\common;

class Jump
{
    public $msg;
    public $url;
    public $wait;
    public function success($msg = '', $url = '/index', $wait = '3')
    {
        $this->msg = $msg;
        $this->url = $url;
        $this->wait = $wait;
        return view(root_path() . 'view/Jump/jump.html', [
            'msg' => $this->msg,
            'url' => $this->url,
            'wait' => $this->wait,
            'type' => 'success'
        ]);
    }
    public function error($msg = '', $url = '/index', $wait = '3')
    {
        $this->msg = $msg;
        $this->url = $url;
        $this->wait = $wait;
        return view(root_path() . 'view/Jump/jump.html', [
            'msg' => $this->msg,
            'url' => $this->url,
            'wait' => $this->wait,
            'type' => 'error'
        ]);
    }
}
