<?php

Route::group(
    [
        'namespace' => 'Sundy\\Laradmin\\Controllers',
        'prefix' => 'admin/',
        'middleware' => 'web'
    ], function (){

    /*
    |--------------------------------------------------------------------------
    | 登录模块
    |--------------------------------------------------------------------------
    */
    Route::get('login','LoginController@showLoginForm')->name('login');
    Route::post('login','LoginController@loginHandle');
    Route::get('/logout', 'LoginController@logout')->name('admin.logout');

    Route::middleware(['auth:admin','rbac'])->group(function (){
        /*
        |--------------------------------------------------------------------------
        | 首页登出模块
        |--------------------------------------------------------------------------
        */
        Route::get('/', 'IndexController@index')->name('admin.index');
        Route::get('/main', 'IndexController@main')->name('admin.main');

        /*
        |--------------------------------------------------------------------------
        | 管理员模块
        |--------------------------------------------------------------------------
        */
        Route::get('users/status/{statis}/{admin}','UsersController@status')->name('users.status');
        Route::resource('users','UsersController',['except' => ['show']]);
        Route::get('users/destroy/{admin}','UsersController@destroy')->name('users.destroy');

        /*
        |--------------------------------------------------------------------------
        | 权限模块
        |--------------------------------------------------------------------------
        */
        Route::get('rules/status/{status}/{rules}', 'RulesController@status')->name('rules.status');
        Route::resource('rules','RulesController',['except' => ['show']]);

        /*
        |--------------------------------------------------------------------------
        | 角色模块
        |--------------------------------------------------------------------------
        */
        Route::get('roles/access/{role}','RolesController@access')->name('roles.access');
        Route::post('roles/group-access/{role}','RolesController@groupAccess')->name('roles.group-access');
        Route::resource('roles','RolesController',['except' => ['show']]);

        /*
        |--------------------------------------------------------------------------
        | 日志模块
        |--------------------------------------------------------------------------
        */
        Route::resource('actions','ActionLogsController',['only'=> ['index','destroy'] ]);

    });


});
