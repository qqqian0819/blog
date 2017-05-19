<?php
namespace app\admin\model;
use think\input;
use think\Model;
class Blog extends Model
{

	/**
	 * 添加博客
	 * @param arrray $data 写入数据的数组
	 * @return bool 成功与否
	*/
	public static function addBlog($data)
	{
		$data['addtime']=time();
		return $res=Blog::create($data);
	}

	/**
	 * 查看某一篇博客
	 * @param string $id 博客id
	 * @return array / false
	*/
	public static function getOne($id)
	{	
		// 默认primary kye
		$list=Blog::get($id);
		$list['addtime']=date('Y-m-d H:i:s',$list['addtime']);
		return $list;
	}

	/**
	 * 获取所有的博文。并修改添加时间的格式
	 * @return array
	 	array{
			[0]=>array{}
	 	}
	*/
	public static function getAll()
	{
		$lists=Blog::where('isdelete',0)->field('')->order('addtime desc')->paginate(10);
		return $lists;
	}


	/**
	 * 关键字搜索相关博文
	 * @param string $key [关键字]
	 * @return array /false
	*/
	public static function searchKey($key)
	{
		// bug:绑定到同一个word  改进方法？？？
		$blogs=Blog::where('content like :word or title like :words or sort like :wordss ')
					->bind(['word'=>"%$key%",'words'=>"%$key%",'wordss'=>"%$key%"])
					->order('addtime desc')
					->paginate(10);
		return $blogs;
	}

	/**
	 * 修改博客
	 * @param array data 传入要修改的数组
	 * @return int $res 操作的行数 0没操作即失败
	*/
	public static function editBlog($data)
	{
		$data['addtime']=time();
		return $res=Blog::where('id',$data['id'])->update($data);
	}


	/**
     * 软删除博客 : isdelete=>1
     * @param int id [博客id]
     * @return bool
	*/
	/*public static function deleBlog($id) 
	{
		$flag=Blog::where('id',$id)->update(['isdelete'=>1]);
		return $flag;
	}*/
}

