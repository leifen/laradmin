<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('remark');
            $table->tinyInteger('order')->default(255)->unsigned();
            $table->tinyInteger('status');
            $table->timestamps();
        });

        $time = \Carbon\Carbon::now();
        \DB::table('roles')->insert([
            'name' => '超级管理员',
            'remark' => '拥有网站最大权限',
            'order' => 1,
            'status' => 1,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
