<?php
namespace Sundy\Laradmin\Observers;

class RuleObserver
{
    public function saving()
    {
        return \Cache::tags('rbac')->flush();
    }

    public function deleting()
    {
        return Cache::tags('rbac')->flush();
    }
}