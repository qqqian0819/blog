<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
class Home extends Controller
{

	// 首页 所有博客
	public function home()
	{

		$blogs=\app\admin\model\Blog::getAll();
		// 熏染模版
		$this->assign('list',$blogs);
		return $this->fetch();
	}

	// 详细博客
	public function detail($id)
	{
		// var_dump($id);
		$blog=\app\admin\model\Blog::getOne($id);
		$lists=\app\admin\model\Message::blogMess($id);
		// 确定回复样式
		foreach ($lists as $v) {
			$v['bg']=$v['lev']%2?'#eee':'#fff';
			$v['lefts']=$v['lev']*2;
			$v['border']=$v['lev']==0? " <hr> " :'';
		}
		// 熏染模版
		$this->assign('list',$lists);
		// 熏染模版
		$this->assign('title',$blog['title']);
		$this->assign('content',$blog['content']);
		$this->assign('addtime',$blog['addtime']);
		$this->assign('sort',$blog['sort']);
		$this->assign('id',$id);
		return $this->fetch();
	}

	// 修改博客显示原有内容
	public function edit($id)
	{
		$blog=\app\admin\model\Blog::getOne($id);
		// 熏染模版
		$this->assign('title',$blog['title']);
		$this->assign('content',$blog['content']);
		$this->assign('addtime',$blog['addtime']);
		$this->assign('sort',$blog['sort']);
		$this->assign('id',$id);
		return $this->fetch('');
	}

	// 修改博客 return int
	public function editBlog()
	{
		$data=input('post.');
		return $res=\app\admin\model\Blog::editBlog($data);
		// $user= new Blog;// $res=$user->save($data,['id'=>$data['id']]);//必须先 use think\model\Blog
		
	}

	// 关键字搜索 return array/false
	public function search()
	{
		$key=input('post.keyword');
		$blogs=\app\admin\model\Blog::searchKey($key);
		$this->assign('list',$blogs);
		return $this->fetch('home');
		
	}

	// 添加评论
	public function addComment()
	{
		if(Request::instance()->isAjax()){
			$data=input('post.');
			// var_dump($data);

			$res=\app\admin\model\Message::addMessage($data);
			return $mess= $res?'评论成功':'评论失败';
		}
	}

	// 删除评论
	public function delComment()
	{
		if(Request::instance()->isAjax()){
			$id=input('post.id');
			$lists=\app\admin\model\Message::delMess($id);
			return '删除成功';
		}
	}
}