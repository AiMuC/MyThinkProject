<?php

namespace app\model;

use think\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $pk = 'username';
}
