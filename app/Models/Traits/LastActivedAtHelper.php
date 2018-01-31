<?php

namespace App\Models\Traits;


use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActivedAtHelper
{
    // 缓存相关
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt()
    {
        // Redis 哈希表的命名，如： larabbs_last_actived_at_2018-01-31
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());
        // 字段名称 如 user_1
        $field = $this->getHashField();
        // 当前时间，如：2018-01-31 23:00:54
        $now = Carbon::now()->toDateTimeString();
        // 数据写入 Redis，字段已存在会更新
        \Redis::hSet($hash, $field, $now);
    }

    public function syncUserActivedAt()
    {
        // Redis 哈希表命名，如 larabbs_last_actived_at2018-01-31
        $hash = $this->getHashFromDateString(Carbon::now()->subDay()->toDateString());
        // 从 Redis 中获取所有哈希表的数据
        $dates = Redis::hGetAll($hash);
        // 变量，并同步到数据库中
        foreach ($dates as $user_id => $actived_at) {
            // 会将 `user_1` 转换为 1
            $user_id = str_replace($this->field_prefix, '', $user_id);
            // 只有当用户存在时才会更新到数据库中
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        // 以数据库为中心的存储，既已同步，即可删除
        Redis::del($hash);
    }

    public function getLastActivedAtAttribute($value)
    {
        // Redis 哈希表的命名，如：larabbs_last_actived_at2018-01-31
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());
        // 字段名称，如：user_1
        $field = $this->getHashField();
        // 三元运算符，优先选择 Redis 的数据，否则使用数据库中
        $datetime = Redis::hGet($hash, $field) ?:
            $value;
        if ($datetime) {
            return new Carbon($datetime);
        } else {
            return $this->created_at;
        }
    }

    public function getHashFromDateString($date)
    {
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        return $this->field_prefix . $this->id;
    }
}