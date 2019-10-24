<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/19
 * Time: 15:52
 */
namespace app\admin\service;
class GoodsService {
    public function getMarket($own_sell){
        if($own_sell!=0){
            $market_price=$own_sell+500;
            return json_encode(["status"=>1,"market_price"=>$market_price]);
        }else{
            return json_encode(["status"=>0,"msg"=>"没有输入值"]);
        }


    }
}