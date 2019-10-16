<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/14
 * Time: 14:26
 */
namespace app\admin\model;

use think\Model;
class RoleModel extends Model
{
    protected $pk="role_id";
    public function node(){
        return $this->belongsToMany("NodeModel",'role_node',"node_id","role_id");
    }
}

