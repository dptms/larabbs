<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['content'];

    // 回复所属用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 回复所属话题
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
