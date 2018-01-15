<?php
namespace Sundy\Laradmin\Models\Traits;

use Illuminate\Support\Facades\Cache;
use Sundy\Laradmin\Handlers\Tree;
use Sundy\Laradmin\Repositories\RulesRepository;

trait RbacCheck
{
    // 缓存相关配置
    protected $cache_key = '_cache_rules';

    protected $menu_cache = '_menu_cache'; //菜单缓存key

    /**
     * 获取当前用户的所有权限
     * @return mixed
     */
    public function getRules()
    {
        $cache_key = $this->id . $this->cache_key;

        if(!Cache::tags(['rbac', 'rules'])->has($cache_key))
        {
            $permissions = [];

            foreach ($this->roles as $role) {
                $permissions = array_merge($permissions, $role->rules()->pluck('route')->toArray());
            }

            /**获得当前用户所有权限路由*/
            $permissions = array_unique($permissions);

            /**将权限路由存入缓存中*/
            Cache::tags(['rbac', 'rules'])->forever($cache_key, $permissions);
        }

        return Cache::tags(['rbac', 'rules'])->get($cache_key);
    }

    /**
     * 获取树形菜单导航栏
     * @return array
     */
    public function getMenus()
    {
        $menu_cache = $this->id . $this->menu_cache;

        if (!Cache::tags(['rbac', 'menus'])->has($menu_cache))
        {
            $rules = [];
            //判断是否是超级管理员用户组
            if (in_array(1, $this->roles->pluck('id')->toArray()))
            {
                //超级管理员用户组获取全部权限数据
                $rules = (new RulesRepository())->getRulesAndPublic()->toArray();

            } else {

                foreach ($this->roles as $role)
                {
                    $rules = array_merge($rules, $role->rulesPublic()->toArray());
                }

                if($rules)
                {
                    $rules = unique_arr($rules);
                }
            }

            /**将权限路由存入缓存中*/
            Cache::tags(['rbac', 'menus'])->put($menu_cache, $rules,86400);
        }


        $rules = Cache::tags(['rbac', 'menus'])->get($menu_cache);

        return Tree::array_tree($rules);
    }

    /**
     * 删除权限缓存和菜单缓存
     * @return bool
     */
    public function clearRuleAndMenu()
    {
        return Cache::tags(['rbac', 'menus'])->flush();
    }
}