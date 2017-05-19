<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Model\Messgae;

class Message extends Controller
{
	// 首页
	public function message()
	{
		$lists=\app\admin\model\Message::getAll();
		// 确定回复样式
		foreach ($lists as $v) {
			$v['bg']=$v['lev']%2?'#eee':'#fff';
			$v['lefts']=$v['lev']*2;
			$v['border']=$v['lev']==0? " <hr> " :'';
		}
		// 熏染模版
		$this->assign('list',$lists);
		return $this->fetch();


	}

	// 添加留言 return string
	public function add()
	{
		if(Request::instance()->isAjax()){
			$data=input('post.');
			// var_dump($data);

			$res=\app\admin\model\Message::addMessage($data);
			return $mess= $res?'留言成功':'留言失败';
		}
	}

	// 删除留言
	public function del()
	{
		$id=input('post.id');
		$lists=\app\admin\model\Message::delMess($id);
		return '删除成功';
	}

	// 测试
	public function test(){
		/*$list=\app\admin\model\Message::getAll();
		// $lists=\app\admin\model\Message::getTree($list,0);
		// 确定回复样式
		foreach ($lists as $v) {
			$v['lev']=$v['lev']%2?'repaly2':'replay1';
		}
		print_r($lists);*/
		$lists=\app\admin\model\Message::delMess(4);
		var_dump($lists);



	}
}