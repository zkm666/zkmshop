<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/12
 * Time: 14
 */
namespace app\admin\controller;
use app\admin\model\GoodsAttrModel;
use app\admin\model\GoodsModel;
use think\Controller;
class ProductController extends CommonController
{
    public function show()
    {
        $goods_id=input("goods_id");
        $goods=GoodsModel::get($goods_id);
        $product=$goods->product;
        foreach($product as $key=>$val){
            $goods_attr_id=explode(",",$val["goods_attr_id"]);
            //dump($goods_attr_id);
            $goods_attr_name=(new GoodsAttrModel())->
            where("goods_id",$goods_id)->select($goods_attr_id)->toArray();
            //dump($goods_attr_name);
            $attr=array_column($goods_attr_name,"attr_select","goods_attr_id");
            //dump($attr);
            $val["goods_attr_id"] =implode("+",$attr);
        }
        return view("",["product"=>$product,"goods_id"=>$goods_id]);
//        $attr=$goods->attr->toarray();
//        $product=[];
//        $a = $attr[0]["pivot"]["attr_name"];
//        foreach ($attr as $k => $v) {
//            if ($v["attr_type"] == 1) {
//                if ($a == $v["pivot"]["attr_name"]) {
//                    $product[$a][] = $v["pivot"];
//                } else {
//                    $a = $v["pivot"]["attr_name"];
//                    $product[$a][] = $v["pivot"];
//                }
//            }
//        }
        //return view("",["product"=>$product,"goods_id"=>$goods_id]);
    }
    public function add()
    {
        if(request()->isGet()){
            $goods_id=input("goods_id");
            $goods=GoodsModel::get($goods_id);
            $attr=$goods->attr->toarray();
            $product=[];
            $a = $attr[0]["pivot"]["attr_name"];
            foreach ($attr as $k => $v) {
                if ($v["attr_type"] == 1) {
                    if ($a == $v["pivot"]["attr_name"]) {
                        $product[$a][] = $v["pivot"];
                    } else {
                        $a = $v["pivot"]["attr_name"];
                        $product[$a][] = $v["pivot"];
                    }
                }
            }
            return view("",["product"=>$product,"goods_id"=>$goods_id]);
        }
        if(request()->isPost()){
            $goods_id=request()->post("goods_id");
            $data=request()->except('goods_id','post');
            $product=[];
            foreach($data as $key=>$val){
                foreach($val as $k=>$v){
                    $v['goods_attr_id']=implode(",",$v['attr_select']);
                    unset($v['attr_select']);
                    $product[]=$v;
                }
            }
            $goodsModel=GoodsModel::find($goods_id);
            if($goodsModel->product()->saveAll($product)){
                $this->success("添加成功","goods/show");
            }else{
                $this->error("添加失败");
            }
        }
    }
}