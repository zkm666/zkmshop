<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/12
 * Time: 14:42
 */
namespace app\admin\controller;

use app\admin\model\NodeModel;
use app\admin\service\NodeService;
use think\Controller;

class NodeController extends CommonController
{
    public function show()
    {
        $nodeModel=new NodeModel();
        $nodeServer=new NodeService();
        $nodeOrder=$nodeServer->getNodeOrder($nodeModel->all());
        return view('',["nodeOrder"=>$nodeOrder]);
    }
    public function add()
    {
        if(request()->isGet()){
            $nodeModel=new NodeModel();
            $nodeServer=new NodeService();
            $nodeOrder=$nodeServer->getNodeOrder($nodeModel->all());
            return view('',["nodeOrder"=>$nodeOrder]);
        }
        if(request()->isPost()){
            $nodeModel=new NodeModel();
            if($nodeModel->allowField(true)->save(request()->post())){
                $this->success("添加权限成功",'show');
            }else{
                $this->error("添加权限失败");
            }
        }
    }
    public function delete()
    {
        return view();
    }
    public function update()
    {
        return view();
    }
}