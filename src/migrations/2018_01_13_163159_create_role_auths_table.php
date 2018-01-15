<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_auth', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->nullable();
            $table->integer('rule_id')->nullable();
            $table->timestamps();
        });

        $time = \Carbon\Carbon::now();
        \DB::table('role_auth')->insert([
            'role_id' => 1,
            'rule_id' => 1,
            'created_at' => $time,
            'updated_at' => $time
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_auth');
    }
}
