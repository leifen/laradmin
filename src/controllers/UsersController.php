<?php

namespace Sundy\Laradmin\Controllers;

use Illuminate\Http\Request;
use Sundy\Laradmin\Repositories\RolesRepository;
use Sundy\Laradmin\Requests\AdminRequest;
use Sundy\Laradmin\Services\AdminsService;

class UsersController extends BaseController
{

    protected $adminsService;

    protected $rolesRepository;

    /**
     * UsersController constructor.
     * @param AdminsService $adminsService
     * @param RolesRepository $rolesRepository
     */
    public function __construct(AdminsService $adminsService, RolesRepository $rolesRepository)
    {
        $this->adminsService = $adminsService;

        $this->rolesRepository = $rolesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = $this->adminsService->getAdminsWithRoles();

        return $this->view(null, compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->rolesRepository->getRoles();
        return $this->view(null,compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $this->adminsService->create($request);

        flash('添加管理员成功')->success()->important();

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = $this->adminsService->ById($id);

        $roles = $this->rolesRepository->getRoles();

        return $this->view(null, compact('admin','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->adminsService->update($request,$id);

        flash('更新资料成功')->success()->important();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = $this->adminsService->ById($id);

        if(empty($admin))
        {
            flash('删除失败')->error()->important();

            return redirect()->route('users.index');
        }

        $admin->roles()->detach();

        $admin->delete();

        flash('删除成功')->success()->important();

        return redirect()->route('users.index');
    }

    /**
     * 禁用/启用
     * @param $status
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @author sundy
     */
    public function status($status, $id)
    {
        $admin = $this->adminsService->ById($id);

        if(empty($admin))
        {
            flash('操作失败')->error()->important();

            return redirect()->route('users.index');
        }

        $admin->update(['status'=>$status]);

        flash('更新状态成功')->success()->important();

        return redirect()->route('users.index');
    }
}
