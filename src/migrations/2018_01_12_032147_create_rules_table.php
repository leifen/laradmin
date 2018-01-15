<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('route');
            $table->integer('parent_id');
            $table->tinyInteger('is_hidden');
            $table->integer('sort');
            $table->tinyInteger('status');
            $table->string('fonts');
            $table->timestamps();
        });

        $time = \Carbon\Carbon::now();
        $rules = [
            [
               'name' => '后台首页',
               'route' => 'admin.index',
               'parent_id' => 0,
               'is_hidden' => 0,
               'sort' => 1,
               'status' => 1,
               'fonts' => 'home',
               'created_at' => $time,
               'updated_at' => $time,
            ],
            [
                'name' => '欢迎界面',
                'route' => 'admin.main',
                'parent_id' => 1,
                'is_hidden' => 1,
                'sort' => 255,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '系统管理',
                'route' => '',
                'parent_id' => 0,
                'is_hidden' => 0,
                'sort' => 2,
                'status' => 1,
                'fonts' => 'users',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '管理员管理',
                'route' => 'users.index',
                'parent_id' => 3,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '添加页面',
                'route' => 'users.create',
                'parent_id' => 4,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '添加数据',
                'route' => 'users.store',
                'parent_id' => 4,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '修改页面',
                'route' => 'users.edit',
                'parent_id' => 4,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '数据更新',
                'route' => 'users.update',
                'parent_id' => 4,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '状态修改',
                'route' => 'users.status',
                'parent_id' => 4,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '用户删除',
                'route' => 'users.destroy',
                'parent_id' => 4,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '角色管理',
                'route' => 'roles.index',
                'parent_id' => 3,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '添加页面',
                'route' => 'roles.create',
                'parent_id' => 11,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '添加数据',
                'route' => 'roles.store',
                'parent_id' => 11,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '修改页面',
                'route' => 'roles.edit',
                'parent_id' => 11,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '数据更新',
                'route' => 'roles.update',
                'parent_id' => 11,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '权限分配页面',
                'route' => 'roles.access',
                'parent_id' => 11,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '权限分配',
                'route' => 'roles.group-access',
                'parent_id' => 11,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '删除角色',
                'route' => 'roles.destroy',
                'parent_id' => 11,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '权限管理',
                'route' => 'rules.index',
                'parent_id' => 3,
                'is_hidden' => 0,
                'sort' => 3,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '添加页面',
                'route' => 'rules.create',
                'parent_id' => 19,
                'is_hidden' => 1,
                'sort' => 13,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '添加数据',
                'route' => 'rules.store',
                'parent_id' => 19,
                'is_hidden' => 1,
                'sort' => 5,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '修改页面',
                'route' => 'rules.edit',
                'parent_id' => 19,
                'is_hidden' => 1,
                'sort' => 13,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '数据更新',
                'route' => 'rules.update',
                'parent_id' => 19,
                'is_hidden' => 1,
                'sort' => 7,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '状态修改',
                'route' => 'rules.status',
                'parent_id' => 19,
                'is_hidden' => 1,
                'sort' => 8,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '删除权限',
                'route' => 'rules.destroy',
                'parent_id' => 19,
                'is_hidden' => 1,
                'sort' => 9,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '操作日志',
                'route' => 'actions.index',
                'parent_id' => 3,
                'is_hidden' => 0,
                'sort' => 9,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => '删除日志',
                'route' => 'actions.destroy',
                'parent_id' => 26,
                'is_hidden' => 1,
                'sort' => 9,
                'status' => 1,
                'fonts' => '',
                'created_at' => $time,
                'updated_at' => $time,
            ]
        ];
        \DB::table('rules')->insert($rules);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rules');
    }
}
