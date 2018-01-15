<?php

namespace Sundy\Laradmin\Controllers;

use Illuminate\Http\Request;
use Sundy\Laradmin\Requests\RuleRequest;
use Sundy\Laradmin\Services\RulesService;

class RulesController extends BaseController
{
    protected $rulesService;

    /**
     * RulesController constructor.
     * @param $rulesService
     */
    public function __construct(RulesService $rulesService)
    {
        $this->rulesService = $rulesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = $this->rulesService->getRulesTree();

        return $this->view(null,compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rules = $this->rulesService->getRulesTree();

        return $this->view(null,compact('rules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RuleRequest $request)
    {
        $this->rulesService->create($request->all());

        flash('添加权限成功')->success()->important();

        return redirect()->route('rules.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rules = $this->rulesService->getRulesTree();
        $rule = $this->rulesService->ById($id);

        return $this->view(null,compact('rule','rules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RuleRequest $request, $id)
    {
        $rule = $this->rulesService->ById($id);
        if(is_null($rule))
        {
            flash('你无权操作')->error()->important();
        }

        $rule->update($request->all());
        flash('更新成功')->success()->important();

        return redirect()->route('rules.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rule = $this->rulesService->ById($id);

        if(empty($rule))
        {
            flash('删除失败')->error()->important();

            return redirect()->route('rules.index');
        }

        $rule->delete();

        flash('删除成功')->success()->important();

        return redirect()->route('rules.index');
    }

    /**
     * 状态更新
     * @param $status
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @author sundy
     */
    public function status($status, $id)
    {

        $rule = $this->rulesService->ById($id);

        if(empty($rule))
        {
            flash('操作失败')->error()->important();

            return redirect()->route('rules.index');
        }

        $rule->update(['is_hidden'=>$status]);

        flash('更新状态成功')->success()->important();

        return redirect()->route('rules.index');
    }
}
