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
class GoodsModel extends Model
{
    protected $pk="goods_id";
    public function attr(){
        return $this->belongsToMany('AttrModel',"goods_attr","attr_id","goods_id");
    }
    public function product(){
        return $this->hasMany('ProductModel',"goods_id");
    }
}