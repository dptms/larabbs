<?php

namespace App\Models;

use App\Models\Traits\ActiveUser;
use App\Models\Traits\LastActivedAtHelper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use ActiveUser; // 活跃用户统计
    use LastActivedAtHelper; // 用户最后活跃时间记录
    use HasRoles;
    use Notifiable {
        // 重写 trait 里面 notify 方法 变更方法名为 laravelNotify
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        if ($this->id === \Auth::id()) {
            return;
        }
        $this->increment('notification_count', 1);
        $this->laravelNotify($instance);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

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

    public function setPasswordAttribute($value)
    {
        if (strlen($value) != 60) {
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    public function setAvatarAttribute($value)
    {
        if (!starts_with($value, 'http')) {
            $value = config('app.url') . '/uploads/images/avatar/' . $value;
        }

        $this->attributes['avatar'] = $value;
    }
}
