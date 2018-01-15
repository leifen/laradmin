<?php

namespace Sundy\Laradmin\Middleware;

use Auth;
use Closure;
use Sundy\Laradmin\Services\ActionLogsService;

class RbacAuth
{
    protected $actionLogsService;

    /**
     * RbacAuth constructor.
     * @param $actionLogsService
     */
    public function __construct(ActionLogsService $actionLogsService)
    {
        $this->actionLogsService = $actionLogsService;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**判断登录用户是否已经登录*/
        if(!Auth::guard('admin')->check())
        {
            return redirect()->route('login');
        }

        /**记录用户操作日志**/
        if(in_array($request->method(),['POST','PUT','PATCH','DELETE']))
        {
            $this->actionLogsService->mudelActionLogCreate($request);
        }

        if(!Auth::guard('admin')->user()->hasRule(\Route::currentRouteName()))
        {
            return viewShow('你无权访问','admin.index');
        }

        return $next($request);
    }
}
