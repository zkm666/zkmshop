<?php
namespace app\admin\service;
use app\admin\model\CateModel;

class CateService{
    public function getCateOrder($cate,$cate_pid=0,$level=0){
        $cateOrder=[];
        foreach($cate as $key=>$val){
            if($val->cate_pid==$cate_pid){
                $val->level=$level;
                array_push($cateOrder,$val);
                $cateOrder=array_merge($cateOrder,$this->getCateOrder($cate,$val->cate_id,$level+1));
            }
        }
        return $cateOrder;
    }
    public function getCateTree($cate,$cate_pid=0){
        $cateTree=[];
        foreach($cate as $key=>$val){
            if($val->cate_pid==$cate_pid){
                $val->child=$this->getCateTree($cate,$val->cate_id);
                $cateTree[]=$val;
            }
        }
        return $cateTree;
    }
}