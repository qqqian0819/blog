<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use app\common\model\Blog;
use app\common\model\Message;
class Index extends Controller
{

    // 首页 所有博客
    public function home()
    {
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
        // var_dump($id);
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

    // 添加评论
    public function addComment()
    {
        if(Request::instance()->isAjax()){
            $data=input('post.');

            $res=Message::addMessage($data);
            return $mess= $res?'评论成功':'评论失败';
        }
    }

    // 留言列表
    public function message()
    {
        $lists=Message::getAll();
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

    // 留言 return string
    public function add()
    {
        if(Request::instance()->isAjax()){
            $data=input('post.');
            // var_dump($data);

            $res=Message::addMessage($data);
            return $mess= $res?'留言成功':'留言失败';
        }
    }

    // 某年某月的文档
    public function date($date)
    {
        $blogs=Blog::findDate($date);
        $this->assign('list',$blogs);

        // 文章归档
        $files=Blog::timeFile();
        $this->assign('files',$files);

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

    public function test($id=9){
        $blog=Blog::getOne($id);//博客列
        $arr=$blog['pre'];
        var_dump($blog['pre'][0]['id']);
        // var_dump($blog['pre'].'id');
        // var_dump($blog['pre']);
    }
}
