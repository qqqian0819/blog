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

        // 渲染模版
        return $this->fetch();
    }

    // 详细博客
    public function detail($id)
    {
        // var_dump($id);
        $blog=Blog::getOne($id);
        $lists=Message::blogMess($id);
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
    // 关键字搜索 return array/false
    public function search()
    {
        $key=input('post.keyword');
        $blogs=Blog::searchKey($key);
        $this->assign('list',$blogs);

        // 文章归档
        $files=Blog::timeFile();
        $this->assign('files',$files);

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

    // 生活列表
    public function life(){
        return $this->fetch();
    }

    // 某年某与的文档
    public function date($date){
        $blogs=Blog::findDate($date);
        $this->assign('list',$blogs);

        // 文章归档
        $files=Blog::timeFile();
        $this->assign('files',$files);

        return $this->fetch('home');
    }


    public function test(){
        $list=Blog::sort('skill');
        var_dump($list);
    }
}
