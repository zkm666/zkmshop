<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/12
 * Time: 14:42
 */
namespace app\admin\controller;

use app\admin\model\AttrModel;
use app\admin\model\TypeModel;
use think\Controller;

class AttrController extends CommonController
{
    public function show()
    {
        $type_id=input("type_id");
        $type= TypeModel::get($type_id);
        $attr = $type->attr;
        return view("",["attr"=>$attr,"type"=>$type]);
    }
    public function add(){
        $type_id=input("type_id");
        if(request()->isGet()){
            $attr=TypeModel::all();
            return view("",["attr"=>$attr,"type_id"=>$type_id]);
        }
        if(request()->isPost()){
            $data=request()->post();
            $attr=new AttrModel();
            $res=$attr->save($data);
            if($res){
                $this->success('添加成功', "type/show");
            }else{
                $this->error("添加失败");
            }
        }


    }
}