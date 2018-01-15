<?php
namespace Sundy\Laradmin\Observers;

use Sundy\Laradmin\Models\Admin;

class AdminObserver
{
    /**
     * @param Admin $admin
     */
    public function saving(Admin $admin)
    {
        $admin->clearRuleAndMenu();
    }

    /**
     * 监听用户删除事件
     */
    public function deleting(Admin $admin)
    {
        $admin->clearRuleAndMenu();
    }
}