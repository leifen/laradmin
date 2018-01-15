<?php
namespace Sundy\Laradmin\Repositories;

use Sundy\Laradmin\Models\Admin;

class AdminsRepository
{

    /**
     * 根据name查询管理员资料
     * @param $name
     * @return mixed
     */
    public function ByName($name)
    {
        return Admin::where('name',$name)->first();
    }

    /**
     * 获取管理员列表 with ('roles')
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @author sundy
     */
    public function getAdminsWithRoles()
    {
        return Admin::with('roles')->latest('updated_at')->paginate('10');
    }

    /**
     * 创建管理员
     * @param array $params
     * @return mixed
     * @author sundy
     */
    public function create(array $params)
    {
        return Admin::create($params);
    }

    /**
     * 根据id获取管理员资料
     * @param $id
     * @return mixed
     * @author sundy
     */
    public function ById($id)
    {
        return Admin::find($id);
    }
}