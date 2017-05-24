<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\common\model\Blog;
use app\common\model\Message;
class Home extends Controller
{

	// 首页 所有博客
	public function home()
	{  
        // 未登录
        if (!session('?ext_user')) {
            $this->redirect('login/login');
            exit();
        }
		// 博客
        $blogs=Blog::getAll();
        $this->assign('list',$blogs);
        // 文章归档
        $files=Blog::timeFile();
        $this->assign('files',$files);
        // 文章分类
        $sorts=Blog::sort();
        $this->assign('sorts',$sorts);

        // 渲染模版
        return $this->fetch();
	}

	// 详细博客
	public function detail($id)
	{  
        if (!session('?ext_user')) {
            $this->redirect('login/login');
            exit();
        }
        $blog=Blog::getOne($id);//博客列
        $lists=Message::blogMess($id);//留言列
        // 确定留言回复样式
        foreach ($lists as $v) {
            $v['bg']=$v['lev']%2?'#eee':'#fff';
            $v['lefts']=$v['lev']*2;
            $v['border']=$v['lev']==0? " <hr> " :'';
        }
        // 熏染模版
        $this->assign('list',$lists);
        $this->assign('blog',$blog);
        // 无相关博客 ???home.css 无效
        $this->assign('empty','<p class="empty" style="text-align:center;font-size:1.3em;margin-top:1em;">暂无留言</p>');
        return $this->fetch('detail');
	}

	// 修改博客显示原有内容
	public function edit($id)
	{  
        if (!session('?ext_user')) {
            $this->redirect('login/login');
            exit();
        }
		$blog=Blog::getOne($id);
		$sorts=Blog::sort();//获取所有分类
		// 熏染模版
		$this->assign('blog',$blog);
		$this->assign('sorts',$sorts);
		return $this->fetch('');
	}

	// 修改博客 return int
	public function editBlog()
	{
		$data=input('post.');
		// return var_dump($data);
		$res=Blog::editBlog($data);
		if($res){
			$this->redirect('detail', ['id' => input('post.id')]);
            // $this->success('新增成功', 'detail?id='.input('post.id'));
        } else {
            //错误默认跳转页面是返回前一页 history.back(-1);
            $this->error('修改失败');
        }
		
		
	}

	// 关键字搜索 return array/false
	public function search()
	{
		$key=input('post.keyword');
        $blogs=Blog::searchKey($key);
        $this->assign('list',$blogs);
        // 无相关博客 ???home.css 无效
        $this->assign('empty','<p class="empty" style="text-align:center;font-size:2em;margin-top:2em;">暂时没有相关博客</p>');

        // 文章归档
        $files=Blog::timeFile();
        $this->assign('files',$files);
        // 文章分类
        $sorts=Blog::sort();
        $this->assign('sorts',$sorts);

        return $this->fetch('home');
		
	}

    // 分类博客
    public function sort()
    {
        $sort=trim(input('get.sort'));
        $blogs=Blog::getSort($sort);
        $this->assign('list',$blogs);

        // 文章归档
        $files=Blog::timeFile();
        $this->assign('files',$files);
        // 文章分类
        $sorts=Blog::sort();
        $this->assign('sorts',$sorts);

        return $this->fetch('home');
    }

    // 归档博客
    public function dateSort()
    {
        $times=input('get.date');
        $blogs=Blog::findDate($times);
        $this->assign('list',$blogs);

        // 文章归档
        $files=Blog::timeFile();
        $this->assign('files',$files);
        // 文章分类
        $sorts=Blog::sort();
        $this->assign('sorts',$sorts);

        return $this->fetch('home');
    }

	// 添加评论
	public function addComment()
	{
		if(Request::instance()->isAjax()){
			$data=input('post.');
			// var_dump($data);

			$res=Message::addMessage($data);
			return $mess= $res?'评论成功':'评论失败';
		}
	}

	// 删除评论
	public function delComment()
	{
		if(Request::instance()->isAjax()){
			$id=input('post.id');
			$lists=Message::delMess($id);
			return '删除成功';
		}
	}


}
