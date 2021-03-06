<?php

namespace App\Models\Traits;

use App\Models\Reply;
use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait ActiveUser
{
    // 用于存放临时用户数据
    protected $users = [];
    // 配置信息
    protected $topic_weight = 4; // 话题权重
    protected $reply_weight = 1; // 回复权重
    protected $pass_days = 7; //多少天内发表过内容
    protected $user_number = 6; //取出多少用户

    // 缓存相关配置
    protected $cache_key = 'larabbs_active_users';
    protected $cache_expire_in_minutes = 65;

    public function getActiveUsers()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能娶到，便直接返回数据。
        // 否则运行匿名函数中的代码取出活跃用户数据，返回的同时做了缓存
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function () {
            return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        // 取得活跃用户列表
        $active_users = $this->calculateActiveUsers();
        // 并加以缓存
        $this->cacheActiveUsers($active_users);
    }

    private function calculateTopicScore()
    {
        // 从话题数据表里去除限定时间范围 ($pass_days) 内，有发表过话题的用户
        // 并且同时取出用户此段时间内发生发布话题的数量
        $topic_users = Topic::query()->select(DB::raw('user_id,count(*) as topic_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();
        foreach ($topic_users as $user) {
            $this->users[$user->user_id]['score'] = $this->topic_weight * $user->topic_count;
        }
    }

    private function calculateReplyScore()
    {
        // 从回复数据表里去除限定时间范围 ($pass_days) 内，有发表过回复的用户
        // 并且同时取出用户此时间段内发布回复的数量
        $reply_users = Reply::query()->select(DB::raw('user_id,count(*) as reply_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();
        foreach ($reply_users as $user) {
            $reply_score = $this->reply_weight * $user->reply_count;
            if (isset($this->users[$user->user_id])) {
                $this->users[$user->user_id]['score'] += $reply_score;
            } else {
                $this->users[$user->user_id]['score'] = $reply_score;
            }
        }
    }

    private function cacheActiveUsers($active_users)
    {
        // 将数据放入缓存中
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_minutes);
    }

    private function calculateActiveUsers()
    {
        $this->calculateTopicScore();
        $this->calculateReplyScore();

        // 数组按组照分排序
        $users = array_sort($this->users, function ($user) {
            return $user['score'];
        });

        // 我们要的是倒序，高分靠前，第二个参数为保持数组的 KEY 不变
        $users = array_reverse($users, true);

        // 只获取我们想要的数量
        $users = array_slice($users, 0, $this->user_number, true);

        // 新建一个空集合
        $active_users = collect();

        foreach ($users as $user_id => $score) {
            // 寻找下是否可以找到用户
            $user = $this->find($user_id);

            // 如果数据库里有该用户的话
            if(count($user)){
                // 将此用户实体放入集合末尾
                $active_users->push($user);
            }
        }

        // 返回数据
        return $active_users;
    }
}