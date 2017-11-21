<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 关联话题模型 一对多
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // 判断是否是作者
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    // 用户所有评论
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
