<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/12
 * Time: 14:42
 */
namespace app\admin\controller;

use app\admin\model\TypeModel;
use think\Controller;

class TypeController extends CommonController
{
    public function show()
    {
        $type=TypeModel::all();
        return view("",["type"=>$type]);
    }
    public function add()
    {
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){
            $data=request()->post();
            $type=new TypeModel();
            $res=$type->save($data);
            if($res){
                $this->success("添加类型成功","show");
            }else{
                $this->error("添加失败");
            }
        }
    }
    public function getType(){
        $type_id=request()->post("type_id");
        $type=TypeModel::get($type_id);
        $group_name=$type["group_name"];
        $group_name=explode(",",$group_name);
        if($type){
            echo json_encode(["status"=>1,"msg"=>"ok","type"=>$group_name]);
        }else{
            echo json_encode(["status"=>1,"msg"=>"not"]);
        }
    }

}