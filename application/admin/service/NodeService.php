<?php
namespace app\admin\service;
use app\admin\model\NodeModel;

class NodeService{
    public function getNodeOrder($nodes,$node_pid=0,$level=0){
        $nodeOrder=[];
        foreach($nodes as $key=>$val){
            if($val->node_pid==$node_pid){
                $val->level=$level;
                array_push($nodeOrder,$val);
                $nodeOrder=array_merge($nodeOrder,$this->getNodeOrder($nodes,$val->node_id,$level+1));
            }
        }
        return $nodeOrder;
    }
    public function getNodeTree($nodes,$node_pid=0){
        $nodeTree=[];
        foreach($nodes as $key=>$val){
            if($val->node_pid==$node_pid){
                $val->child=$this->getNodeTree($nodes,$val->node_id);
                $nodeTree[]=$val;
            }
        }
        return $nodeTree;
    }
}