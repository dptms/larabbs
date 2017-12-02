<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 创建权限
        \Spatie\Permission\Models\Permission::create(['name'=>'manage_contents']);
        \Spatie\Permission\Models\Permission::create(['name'=>'manage_users']);
        \Spatie\Permission\Models\Permission::create(['name'=>'edit_settings']);

        // 创建站长角色 并 分配权限
        $founder = \Spatie\Permission\Models\Role::create(['name'=>'Founder']);
        $founder->givePermissionTo('manage_contents');
        $founder->givePermissionTo('manage_users');
        $founder->givePermissionTo('edit_settings');

        // 创建管理员角色 并 分配权限
        $maintainer = \Spatie\Permission\Models\Role::create(['name'=>'Maintainer']);
        $maintainer->givePermissionTo('manage_contents');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 清除所有数据表数据
        $tables = config('permission.table_names');

        \Illuminate\Database\Eloquent\Model::unguard();
        DB::table($tables['roles'])->delete();
        DB::table($tables['permissions'])->delete();
        DB::table($tables['model_has_permissions'])->delete();
        DB::table($tables['model_has_roles'])->delete();
        DB::table($tables['role_has_permissions'])->delete();
        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
