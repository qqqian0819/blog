<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
class Publish extends Controller
{
	public function addblog()
	{
		return $this->fetch();
	}

	// 发表博文
	public function add()
	{	
		// 收集数据
		$data=input('post.');

		// 如果不引入该model 则需要此处\app\
		$res=\app\admin\model\Blog::addBlog($data);
		return $res?'发表成功':'发表失败';
	}
}