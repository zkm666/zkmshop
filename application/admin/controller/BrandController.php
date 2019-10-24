<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/12
 * Time: 14:42
 */
namespace app\admin\controller;

use app\admin\model\BrandModel;
use think\Controller;

class BrandController extends CommonController
{
    public function show()
    {
        $brand=BrandModel::all();
        return view("",["brand"=>$brand]);
    }
    public function add()
    {
        if(request()->isGet()){
            return view();
        }
        if(request()->ispost()){
            $data=request()->post();

            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file('brand_logo');
            // 移动到框架应用根目录/uploads/ 目录下
            $info = $file->validate()->move("../public/static");
            if($info){
                // 成功上传后 获取上传信息
                // 输出
               $path= $info->getSaveName();

                $data["brand_logo"]=$path;
                $res=new BrandModel();
                $brand=$res->save($data);
                if($brand){
                    $this->success("添加成功","brand/show");
                }else{
                    $this->error("添加失败");
                }
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }

        //$brand=new BrandModel();

    }
}