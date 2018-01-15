<?php

namespace Sundy\Laradmin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Sundy\Laradmin\Handlers\Tree;
use Sundy\Laradmin\Models\Role;
use Sundy\Laradmin\Repositories\RulesRepository;
use Sundy\Laradmin\Requests\RoleRequest;

class RolesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Role $role)
    {
        $roles = $role->paginate(10);

        return $this->view(null,compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->view();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request,Role $role)
    {
        $role->fill($request->all());

        $role->save();

        flash('添加角色成功')->success()->important();

        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return $this->view('edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->all());

        flash('修改成功')->success()->important();

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->rules()->detach(); //删除关联数据

        $role->delete();

        flash('删除成功')->success()->important();

        return redirect()->route('roles.index');
    }

    /**
     * 授权页面
     * @param Role $role
     * @param RulesRepository $rulesRepository
     * @param Tree $tree
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author sundy
     */
    public function access(Role $role, RulesRepository $rulesRepository, Tree $tree)
    {
        $rules = $rulesRepository->getRules();

        $datas = $tree::channelLevel($rules, 0, '&nbsp;', 'id','parent_id');

        $rules = $role->rules->pluck('id')->toArray();

        return $this->view(null,compact('role','datas','rules'));
    }

    /**
     * 授权
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @author sundy
     */
    public function groupAccess(Request $request, Role $role)
    {

        $role->rules()->sync($request->get('rule_id'));

        Cache::tags('rbac')->flush();

        flash('授权成功')->success()->important();

        return redirect()->route('roles.index');
    }
}
