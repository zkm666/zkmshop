<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/14
 * Time: 14:26
 */
namespace app\admin\model;

use think\Db;
use think\Model;
class TypeModel extends Model
{
    protected $pk="type_id";
    public function attr()
    {
        return $this->hasMany('AttrModel');
    }
}