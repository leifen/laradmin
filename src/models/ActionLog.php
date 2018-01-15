<?php

namespace Sundy\Laradmin\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $fillable = ['admin_id','data','type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * data数据修饰器
     * @param $value
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return json_decode($value,true);
    }

}


