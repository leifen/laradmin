<?php
namespace Sundy\Laradmin\Repositories;

use Sundy\Laradmin\Models\Role;

class RolesRepository
{
    /**
     * 获取所有角色
     * @return mixed
     */
    public function getRoles()
    {
        return Role::get();
    }
}