<?php
namespace Sundy\Laradmin\Observers;

use Illuminate\Support\Facades\Cache;

class RoleObserver
{
    public function saving()
    {
        return Cache::tags('rbac')->flush();
    }

    /**
     * 删除角色事件
     */
    public function deleting()
    {
        return Cache::tags('rbac')->flush();
    }
}