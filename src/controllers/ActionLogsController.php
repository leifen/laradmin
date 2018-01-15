<?php

namespace Sundy\Laradmin\Controllers;

use Sundy\Laradmin\Models\ActionLog;
use Sundy\Laradmin\Services\ActionLogsService;

class ActionLogsController extends BaseController
{
    protected $actionLogsService;

    /**
     * ActionLogsController constructor.
     * @param $actionLogsService
     */
    public function __construct(ActionLogsService $actionLogsService)
    {
        $this->actionLogsService = $actionLogsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actions = $this->actionLogsService->getActionLogs();

        return $this->view(null,compact('actions'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActionLog $actionLog)
    {
        $actionLog->delete();

        flash('删除日志成功')->success()->important();

        return redirect()->route('actions.index');
    }

}
