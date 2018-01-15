<?php
namespace Sundy\Laradmin\Repositories;


use Sundy\Laradmin\Models\ActionLog;

class ActionLogsRepository
{
    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return ActionLog::create($data);
    }

    /**
     * 获取全部的操作日志
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @author sundy
     */
    public function getWithAdminActionLogs()
    {
        return ActionLog::with('admin')->latest('created_at')->paginate(20);
    }

}