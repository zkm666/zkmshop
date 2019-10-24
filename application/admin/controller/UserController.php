<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/12
 * Time: 14:42
 */
namespace app\admin\controller;

use app\admin\model\AdminModel;
use app\admin\model\RoleModel;
use think\Controller;
use think\facade\Request;

class UserController extends CommonController
{
    public function admin(){
        $admin=(new AdminModel())->all();
        return view('',["data"=>$admin]);
    }
    //添加管理员
    public function add(){
        if(request()->isGet()){
            $role=(new RoleModel())->all();
            return view('',["data"=>$role]);
        }
        if(request()->isPost()){
            $adminModel=new AdminModel();
            $adminModel->admin_name=request()->post("admin_name");
            $adminModel->admin_sult=$admin_sult=substr(uniqid(),-4);
            $adminModel->admin_pwd=request()->post("admin_pwd");
            $adminModel->admin_add_time=time();
            $adminModel->save();
            $data=request()->post();
            $role_id=$data["role_id"];
            $adminModel->role()->saveAll($role_id);
            $this->success("添加管理员成功",'admin');
        }
    }
    public function password(){
        echo "我是修改自己的密码";
    }
}