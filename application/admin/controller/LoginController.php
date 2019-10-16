<?php
/**
 * Created by PhpStorm.
 * User: zkm
 * Date: 2019/10/12
 * Time: 11:36
 */
namespace app\admin\controller;
use think\captcha\Captcha;
use think\Controller;
use think\Db;
use think\facade\Validate;

class LoginController extends Controller
{
    public function login()
    {
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){
            $admin_name=request()->post("admin_name","");
            $admin_pwd=request()->post("admin_pwd","");
//            $code=request()->post("code","");
//            if(!captcha_check($code)){
//                $this->error("验证码错误");
//            }
            $rule = array(
                "admin_name"  => "require",
                'admin_pwd'   => 'require',
            );

            $msg = [
                'admin_name.require' => '用户名不能为空',
                'admin_pwd.require' => '密码不能为空',
            ];

            $data = array(
                'admin_name'  => $admin_name,
                'admin_pwd'   =>$admin_pwd
            );

            $validate   = Validate::make($rule,$msg);
            $result = $validate->check($data);

            if(!$result) {
                $this->error($validate->getError());
            }
        }
        $res= Db::name('admin')->field("admin_id,admin_name")
            ->where(["admin_name"=>$admin_name,"admin_pwd"=>$admin_pwd])->find();
        if ($res) {
            session("admin",$res);
            Db::name("admin")->where(["admin_id"=>$res['admin_id']])->update(["last_log_time"=>time()]);
            $this->redirect("show/show");
        }else{
            $this->error("填入的账户信息不正确");
        }
    }
 public function logout(){
     session(null);
     $this->redirect("login");
 }

}