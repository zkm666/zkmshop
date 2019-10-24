<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/12
 * Time: 14:42
 */
namespace app\admin\controller;

use app\admin\model\BrandModel;
use app\admin\model\CateModel;
use app\admin\model\GoodsModel;
use app\admin\model\TypeModel;
use app\admin\service\CateService;
use think\Controller;
use think\facade\Request;


class GoodsController extends CommonController
{
    public function show()
    {
        $goods=GoodsModel::all();
        return view("",["goods"=>$goods]);
    }
    public function add()
    {
        if(request()->isGet()){
            $cateModel=new CateModel();
            $cateServer=new CateService();
            $cateOrder=$cateServer->getCateOrder($cateModel->all());
            $brand=BrandModel::all();
            $type=TypeModel::all();
            return view('',["cateOrder"=>$cateOrder,'brand'=>$brand,"type"=>$type]);
        }
        if(request()->isPost()){
            $goods=request()->except("attr_id,attr_name,attr_select,attr_price","post");
            $attr=request()->only("attr_id,attr_name,attr_select,attr_price","post");
            $goodAttr=[];
            if(empty($attr["attr_price"])){
                foreach($attr["attr_id"] as $k1=>$v1){
                    $goodAttr[$k1]["attr_id"]=$v1;
                }
                foreach($attr["attr_select"] as $k2=>$v2){
                    $goodAttr[$k2]["attr_select"]=$v2;
                }
                foreach($attr["attr_name"] as $k3=>$v3){
                    $goodAttr[$k3]["attr_name"]=$v3;
                }
            }else{
                foreach($attr["attr_id"] as $k1=>$v1){
                    $goodAttr[$k1]["attr_id"]=$v1;
                }
                foreach($attr["attr_select"] as $k2=>$v2){
                    $goodAttr[$k2]["attr_select"]=$v2;
                }
                foreach($attr["attr_name"] as $k3=>$v3){
                    $goodAttr[$k3]["attr_name"]=$v3;
                }
                foreach($attr["attr_price"] as $k4=>$v4){
                    $goodAttr[$k4]["attr_price"]=$v4;
                }
            }
            if($goods["goods_num"]==""){
                $goods_num=date("Ymd").substr(uniqid(),-6).rand(1000,9999);
                $goods["goods_num"]=$goods_num;
            }
            $goodsModel=new GoodsModel();
            $res=$goodsModel->save($goods);
            $goods_id=$goodsModel->goods_id;
            $good=GoodsModel::get($goods_id);
            foreach($goodAttr as $key=>$val){
                $attrs=$val;
                $good->attr()->attach($val["attr_id"],$attrs);
            }
            if($res){
                $this->success("添加成功","show");
            }
        }
    }
    public function attr(){
        $type_id=request()->post("type_id");
        $attrmodel=TypeModel::get($type_id);
        $attr=$attrmodel->attr;
        foreach($attr as $key=>$val){
            if($val["attr_select"]!=""){
                $attr[$key]["attr_select"]=explode(",",$val["attr_select"]);
            };
        }
        if($attr){
            echo json_encode(["status"=>1,"msg"=>"ok","attr"=>$attr]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"该类型没有属性"]);
        }
    }
    public function market(){
        $own_sell=request()->post("own_sell");
        if($own_sell!=0){
            $market_price=$own_sell*1.1;
            echo json_encode(["status"=>1,"market_price"=>$market_price]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"没有输入值"]);
        }
    }
    public function addAttr(){
        echo 1;
    }
}