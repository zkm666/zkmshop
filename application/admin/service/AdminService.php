<?php
/**
 * Created by PhpStorm.
 * User: dawei
 * Date: 2019/10/15
 * Time: 18:56
 */
namespace app\admin\service;
use app\admin\model\AdminModel;
use app\admin\model\AdminRoleModel;
use app\admin\model\NodeModel;
use app\admin\model\RoleModel;
use think\facade\Session;
class AdminService{
    public function getNodeByAdminId($admin_id){
        $adminRoleModel=new AdminRoleModel();
        $role_id=$adminRoleModel->where("admin_id",$admin_id)->column("role_id");
        $roleModel=new RoleModel();
        $role=$roleModel->all($role_id);
        $mynode=[];
        foreach($role as $key=>$val){
            $mynode=array_merge($mynode,$val->node->toArray());
        }
        $myaccess=[];
        foreach($mynode as $key=>$val){
            array_push($myaccess,ucfirst(strtolower($val["node_controller"]))."/".strtolower($val["node_action"]));
        }
        $myaccess=array_unique($myaccess);
        return $myaccess;
    }
    //取左侧菜单
    public function getMenu(){
        $admin_name=Session::get("admin")["admin_name"];
        if(in_array($admin_name,config("web.super_admin"))){
            //取所有的权限
            $menu=(new NodeModel())->where("node_ismenu",1)->select()->toArray();
        }else{
            $admin_id=Session::get("admin")["admin_id"];
            $adminModel=new AdminModel();
            $admin=$adminModel->get($admin_id);
            $menu=[];
            foreach($admin->role as $key=>$val){
                foreach($val->node->toArray() as $k=>$v){
                    if($v["node_ismenu"]==1){
                        $menu[]=$v;
                    }
                }
            }
            //去重未实现
        }
        return $menu;
    }
    public function getMenuTree($menu,$pid=0){
        $menuTree=[];
        foreach($menu as $key=>$val){
            if($val["node_pid"]==$pid){
                if($son=$this->getMenuTree($menu,$val['node_id'])){
                    $val["son"]=$son;
                }
                $menuTree[]=$val;
            }
        }
        return $menuTree;
    }

}