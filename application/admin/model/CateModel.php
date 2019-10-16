<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class CateModel extends Model
{
    protected $pk="cate_id";
    public function cateTree()
    {
        $cate=Db::name("cate")->select();
        return $this->sort($cate);
    }

    public function sort($data,$pid=0,$level=0)
    {
        static $arr=array();           //创建静态数组
        foreach ($data as $key => $value) { //循环操作所有的分类
            if($value['cate_pid']==$pid){   //找出第一个顶级分类
                $value['level']=$level;//给顶级分类赋一个层级
                $arr[]=$value;           //将顶级分类放入空数组中
                $this->sort($data,$value['cate_id'],$level+1);//将所有分类进行一个排序
            }
        }
        return $arr;
    }

    public function status($cate_id,$cate_status){
        if($cate_status==1){
            $res=Db::name("cate")->where(["cate_id"=>$cate_id])->update(["cate_status"=>0]);
        }else{
            $res=Db::name("cate")->where(["cate_id"=>$cate_id])->update(["cate_status"=>1]);
        }
        return $res;
    }
}
