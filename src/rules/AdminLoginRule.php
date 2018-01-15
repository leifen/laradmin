<?php

namespace Sundy\Laradmin\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Sundy\Laradmin\Repositories\AdminsRepository;

class AdminLoginRule implements Rule
{

    protected $name;

    protected $adminsRepository;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(AdminsRepository $adminsRepository,$name)
    {
        $this->name = $name;

        $this->adminsRepository = $adminsRepository;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $admin = $this->adminsRepository->ByName($this->name);

        if(is_null($admin)) return false;

        //验证密码是否正确
        return Hash::check($value,$admin->password) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '密码错误';
    }
}
