<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/14
 * Time: 14:26
 */
namespace app\admin\model;

use think\Model;
class AdminModel extends Model
{
    protected $pk="admin_id";
    public function role(){
        return $this->belongsToMany('RoleModel',"admin_role","role_id","admin_id");
    }
}
