<?php
namespace Sundy\Laradmin\Controllers;

use App\Http\Controllers\Controller;
use Sundy\Laradmin\Requests\AdminLoginRequest;
use Sundy\Laradmin\Services\AdminsService;

class LoginController extends Controller
{
    protected $adminsService;

    protected $rolesRepository;

    /**
     * LoginController constructor.
     * @param $adminsService
     */
    public function __construct(AdminsService $adminsService)
    {
        $this->adminsService = $adminsService;
    }

    /**
     * 登陆页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author sundy
     */
    public function showLoginForm()
    {
        return view('vendor.laradmin.login.login');
    }

    /**
     * 管理员登陆
     * @param AdminLoginRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function loginHandle(AdminLoginRequest $request)
    {
        $result = $this->adminsService->login($request);

        if(!$result)
        {
            return viewShow('登录失败','login');
        }

        return viewShow('登录成功!','admin.index','success');
    }

    /**
     * 登出
     * @return \Illuminate\Http\RedirectResponse
     * @author sundy
     */
    public function logout()
    {
        $this->adminsService->logout();

        return redirect()->route('login');
    }
}

