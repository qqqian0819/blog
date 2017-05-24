<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\common\model\Blog;
class Publish extends Controller
{
	public function addblog()
	{
		$sorts=Blog::sort();
		$this->assign('sorts',$sorts);
		return $this->fetch();
	}

	// 发表博文
	public function add()
	{	
		// 收集数据
		$data=input('post.');

		$res=Blog::addBlog($data);
		var_dump($res);
		if($res){
			$this->redirect('Home/detail', ['id' =>$res['id']]);
            // $this->success('新增成功', 'detail?id='.input('post.id'));
        } else {
            //错误默认跳转页面是返回前一页 history.back(-1);
            $this->error('修改失败');
        }
	}
}