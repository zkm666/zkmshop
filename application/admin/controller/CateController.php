<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/12
 * Time: 15:31
 */
namespace app\admin\controller;
use app\admin\model\CateModel;
use think\Controller;
use think\Db;
use think\facade\Request;

class CateController extends CommonController
{
    public function show(){
        $cate=new CateModel();
        $data= $cate->cateTree();
        return view("",["data"=>$data]);
    }
    public function pin(){
       $data= Db::name("pin")->select();
        return view("",["data"=>$data]);
    }
    public function add(){
        if(request()->isGet()){
            $cate=new CateModel();
            $data= $cate->cateTree();
            return view("",["data"=>$data]);
        }
        if(request()->isPost()){
            $data=request()->post();
            $res=Db::name("cate")->insert($data);
            if($res){
                $this->success("添加成功","show");
            }else{
                $this->error("网络异常");
            }
        }
    }
    public function status(){
        $cate_id=request()->post("cate_id");
        $cate_status=request()->post("cate_status");
        $cate=new CateModel();
        $content=$cate->status($cate_id,$cate_status);
        if($content){
            echo json_encode(["status"=>1,"data"=>$content]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"not found"]);
        }

    }
}