<?php
namespace Sundy\Laradmin\Services;

use Auth;
use Sundy\Laradmin\Repositories\RulesRepository;
use Zhuzhichao\IpLocationZh\Ip;
use Sundy\Laradmin\Repositories\ActionLogsRepository;

class ActionLogsService
{
    protected $rulesRepository;

    protected $actionLogsRepository;

    /**
     * ActionLogsService constructor.
     * @param $actionLogsRepository
     */
    public function __construct(ActionLogsRepository $actionLogsRepository,RulesRepository $rulesRepository)
    {
        $this->actionLogsRepository = $actionLogsRepository;
        $this->rulesRepository = $rulesRepository;
    }

    /**
     * 登录操作日志
     * @param $request
     * @return mixed
     */
    public function loginActionLogCreate($request,$status = false)
    {
        //获取当前登录管理员信息
        $admin = Auth::guard('admin')->user();

        $ip = $request->getClientIp();

        $address = Ip::find($ip);

        $action = $status ? "管理员: {$admin->name} 登录成功" : " 登录失败,登录的账号为：{$request->name}　密码为：{$request->password}";

        $data = [
            'ip'=> $ip,
            'address'=> $address[0].$address[1].$address[2],
            'action'=> $action,
        ];

        $datas['data'] = json_encode($data);
        $datas['type'] = 2;
        return $this->actionLogsRepository->create($datas);
    }

    /**
     * 后台操作日志
     * @param $request
     * @return mixed
     */
    public function mudelActionLogCreate($request)
    {
        $path = \Route::currentRouteName();

        $rule = $this->rulesRepository->ByRoute($path);

        if(is_null($rule)) return false;

        //获取当前操作方法上级模块名称
        if($rule->parent_id != 0)
        {
            $parent_rule = $this->rulesRepository->ById($rule->parent_id);
        }

        //获取当前登录管理员信息
        $admin = Auth::guard('admin')->user();

        $address = Ip::find($request->getClientIp());

        $action = "管理员: {$admin->name} 操作了 【{$parent_rule->name}】- {$rule->name} 模块";

        $data = [
            'ip'=> $request->getClientIp(),
            'address'=> $address[0].$address[1].$address[2],
            'action'=> $action,
        ];

        $datas['admin_id'] = $admin->id;
        $datas['data'] = json_encode($data);
        $datas['type'] = 1;
        isset($admin->id) ? $datas['admin_id'] = $admin->id : null;

        return $this->actionLogsRepository->create($datas);
    }

    /**
     * 获取全部的操作日志
     * @return mixed
     * @author sundy
     */
    public function getActionLogs()
    {
        return $this->actionLogsRepository->getWithAdminActionLogs();
    }

}