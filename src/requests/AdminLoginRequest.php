<?php

namespace Sundy\Laradmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sundy\Laradmin\Repositories\AdminsRepository;
use Sundy\Laradmin\Rules\AdminLoginRule;

class AdminLoginRequest extends FormRequest
{


    protected $adminsRepository;

    /**
     * AdminLoginRequest constructor.
     * @param AdminsRepository $adminsRepository
     */
    public function __construct(AdminsRepository $adminsRepository)
    {
        $this->adminsRepository = $adminsRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required',
            'password'          => [
                'required',
                new AdminLoginRule($this->adminsRepository, \Request::get('name'))
            ],
        ];
    }

    /**
     * 提示信息s
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'     => '管理员名称不能为空',
            'password.required' => '密码不能为空',
        ];
    }
}
