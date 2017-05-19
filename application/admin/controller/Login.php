<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class Login extends Controller
{
	// 登录页面
    public function login()
    {
        return $this->fetch();
    }

    // 数据检测
    public function check()
    {
    	if(Request::instance()->isAjax())
        {

            // // 检验验证码
            // if(!captcha_check(input('post.captcha')))
            // {
            //     $ret["message"]="验证码错误";
            //     $ret["status"]=0;
            //     return json($ret);
            // }

            if(input('post.name')!=='qqqian0819blogs')
            {
                $ret["message"]="用户名错误";
                $ret['data']=input('post.');
                $ret["status"]=0; 
                return json($ret);
            }
            if(input('post.pwd')!=='qqqian0819blogs')
            {
                $ret["message"]="密码错误";
                $ret["status"]=0; 
                return json($ret);
            }
            $ret["message"]="登录成功";
            $ret["status"]=1; 
            return json($ret);
        }
        
    }

    public function repath()
    {
        $this->redirect('publish/addblog');
    }
}
