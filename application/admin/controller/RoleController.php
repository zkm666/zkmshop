<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/12
 * Time: 14:42
 */
namespace app\admin\controller;

use app\admin\model\NodeModel;
use app\admin\model\RoleModel;
use app\admin\service\NodeService;
use think\Controller;

class RoleController extends Controller
{
    public function show()
    {
        $res=RoleModel::all();
        return view("",["role"=>$res]);
    }
    public function add()
    {
        if(request()->isGet()){
            $nodeModel=new NodeModel();
            $nodeService=new NodeService();
            $nodeTree=$nodeService->getNodeTree($nodeModel->all());
            return view("",["nodeTree"=>$nodeTree]);
        }
        if(request()->isPost()){
            $roleModel=new RoleModel();
            $roleModel->role_name=request()->post("role_name");
            $roleModel->save();
            $data=request()->post();
            $node_id=$data["node_id"];
            if($node_id){
                $roleModel->node()->saveAll($node_id);
            }
            $this->success("添加角色成功","show");
        }

    }
}