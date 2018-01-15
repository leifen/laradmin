<?php
namespace Sundy\Laradmin\Services;

use \Auth;
use Illuminate\Support\Facades\Hash;
use Sundy\Laradmin\Handlers\ImageUploadHandler;
use Sundy\Laradmin\Repositories\AdminsRepository;

class AdminsService
{
    protected $uploader;

    protected $adminsRepository;

    protected $actionLogsService;

    /**
     * AdminsService constructor.
     * @param AdminsRepository $adminsRepository
     * @param ActionLogsService $actionLogsService
     */
    public function __construct(AdminsRepository $adminsRepository, ActionLogsService $actionLogsService, ImageUploadHandler $imageUploadHandler)
    {
        $this->adminsRepository = $adminsRepository;
        $this->actionLogsService = $actionLogsService;
        $this->uploader = $imageUploadHandler;
    }


    /**
     * 登录管理员
     * @param $request
     * @return bool
     * @author sundy
     */
    public function login($request)
    {
        if(!Auth::guard('admin')->attempt([
            'name'     => $request->name,
            'password' => $request->password,
            'status'   => 1,
        ])){
            //记录登录操作记录
            $this->actionLogsService->loginActionLogCreate($request,false);
            return false;
        }

        //增加登录次数.
        Auth::guard('admin')->user()->increment('login_count');

        //记录登录操作记录
        $this->actionLogsService->loginActionLogCreate($request,true);

        return true;
    }

    /**
     * 退出登录
     * @return mixed
     * @author sundy
     */
    public function logout()
    {
        return Auth::guard('admin')->logout();
    }

    /**
     * 获取管理员列表 with ('roles')
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @author sundy
     */
    public function getAdminsWithRoles()
    {
        return $this->adminsRepository->getAdminsWithRoles();
    }

    /**
     * 管理员创建
     * @param $request
     * @return mixed
     * @author sundy
     */
    public function create($request)
    {
        $datas = $request->all();

        //上传头像
        if ($request->avatr) {
            $result = $this->uploader->save($request->avatr, 'avatrs');
            if ($result) {
                $datas['avatr'] = $result['path'];
            }
        }

        $datas['password'] = Hash::make($request->password);
        $datas['create_ip'] = $request->ip();
        $datas['last_login_ip'] = $request->ip();

        $admin = $this->adminsRepository->create($datas);

        //插入模型关联数据
        $admin->roles()->attach($request->role_id);

        return $admin;
    }

    /**
     * 获取管理员的详细资料
     * @param $id
     * @return mixed
     * @author sundy
     */
    public function ById($id)
    {
        return $this->adminsRepository->ById($id);
    }

    /**
     * 更新管理员资料
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id)
    {
        $datas = $request->all();

        $admin = $this->adminsRepository->ById($id);

        //上传头像
        if ($request->avatr) {
            $result = $this->uploader->save($request->avatr, 'avatrs');
            if ($result) {
                $datas['avatr'] = $result['path'];
            }
        }

        if (isset($datas['password'])) {
            $datas['password'] = Hash::make($request->password);
        } else {
            unset($datas['password']);
        }

        $admin->update($datas);

        //更新关联表数据
        $admin->roles()->sync($request->role_id);

        return $admin;
    }
}