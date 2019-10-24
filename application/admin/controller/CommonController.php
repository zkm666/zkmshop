<?php
namespace app\admin\controller;

use app\admin\service\AdminService;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;
use think\facade\View;

class CommonController extends Controller{
    public function __construct(){
        parent::__construct();
        if(Cookie::get('admin')&&!Session::get("admin")){
            $data=Cookie::get('admin');
            Session::set('admin',$data);
        }
        if(!Session::get("admin")){
            $this->success("非法登录","login/login");
        }
        //检查权限，有权限继续执行，
        if(!$this->checkNode()){
            if(request()->isAjax()){
                return ["status"=>-1,"msg"=>"没有权限操作"];
            }else{
                $this->success("你没有权限操作",'show/show');
            }
        }
        $adminService=new AdminService();
        $menu=$adminService->getMenu();
        $menu=$adminService->getMenuTree($menu);
        View::share("menu",$menu);
    }
    //false 没有权限，true 有权限
    public function checkNode(){
        $currentAdmin=Session::get("admin");
        //检测当前登录用户是否是超级管理员
        if(in_array($currentAdmin["admin_name"],config("web.super_admin"))){
            return true;
        }
        //如果不是超级管理员，检测
        //获取要访问的控制器和方法
        $access=ucfirst(strtolower(request()->controller())."controller")."/".strtolower(request()->action());
        if(in_array($access,config("web.no_check_action"))){
            return true;
        }
        //获取当前登录用户拥有的权限
        $mynode=(new AdminService())->getNodeByAdminId(Session::get("admin")["admin_id"]);
        if(in_array($access,$mynode)){
            return true;
        }else{
            return false;
        }
    }
}
