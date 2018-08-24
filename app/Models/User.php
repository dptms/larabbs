<?php

namespace App\Models;

use App\Models\Traits\ActiveUser;
use App\Models\Traits\LastActivedAtHelper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use QrCode;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use ActiveUser; // 活跃用户统计

    use LastActivedAtHelper; // 用户最后活跃时间记录

    use HasRoles;
    use Notifiable {
        // 重写 trait 里面 notify 方法 变更方法名为 laravelNotify
        notify as laravelNotify;}function notify($instance)
    {
        if ($this->id === \Auth::id()) {
            return;
        }
        $this->increment('notification_count', 1);
        $this->laravelNotify($instance);
    }

    function markAsRead()
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
        'name', 'email', 'password', 'introduction', 'avatar', 'phone', 'weixin_openid', 'weixin_unionid', 'registration_id', 'weixin_session_key', 'weapp_openid',
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
    function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // 判断是否是作者
    function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    // 用户所有评论
    function replies()
    {
        return $this->hasMany(Reply::class);
    }

    function setPasswordAttribute($value)
    {
        if (strlen($value) != 60) {
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    function setAvatarAttribute($value)
    {
        if (!starts_with($value, 'http')) {
            $value = config('app.url') . '/uploads/images/avatar/' . $value;
        }

        $this->attributes['avatar'] = $value;
    }

    function getJWTIdentifier()
    {
        return $this->getKey();
    }

    function getJWTCustomClaims()
    {
        return [];
    }

    function qrcode()
    {
        return QrCode::format('png')->size(300)->geo(37.822214, -122.481769);
        return QrCode::format('png')
            ->size(300)
            ->margin(0)
            ->errorCorrection('H')
            ->merge($this->avatar, 0.3, true)
            ->generate(route('users.show', $this));
    }
}
