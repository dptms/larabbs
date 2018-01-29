<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

/**
 * Class CalculateActiveUser
 * @package App\Console\Commands
 */
class CalculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs:calculate-active-user';

    /**
     * The console command description.
     *
     * @var string
     */
    // 命令描述
    protected $description = '生成活跃用户';


    /**
     * CalculateActiveUser constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param User $user
     */
    // 最终执行的方法
    public function handle(User $user)
    {
        // 在命令行打印一行信息
        $this->info('开始计算...');

        $user->calculateAndCacheActiveUsers();

        $this->info("成功生成");
    }
}
