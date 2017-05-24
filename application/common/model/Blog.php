<?php
namespace app\common\model;
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
	 * 查看某一篇博客以及获取上下篇未删除博客的id标题[id]
	 * @param string $id 博客id
	 * @return array / false
	*/
	public static function getOne($id)
	{	
		// 获取当前的博客的信息
		$list=Blog::get($id);
		// 获取上下一篇博客
		$list['pre']=Blog::field('id,title')
					->where('isdelete=0 and id<'.$id)
					->order('id desc')
					->limit(1)
					->select();
		$list['next']=Blog::field('id,title')
					->where('isdelete=0 and id>'.$id)
					->limit(1)
					->select();	
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

		$blogs=Blog::where('content|title|sort','like','%'.$key.'%')
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

	/**
	 * 所有文章归档
	 * @return array{
	 			[0]=>array([years]=>,[months]=>,[num]=>)
	 			}
	*/
	public static function timeFile()
	{
		$sql="SELECT FROM_UNIXTIME(addtime,'%Y') years,FROM_UNIXTIME(addtime,'%m') months,COUNT(id) num FROM tp_blog WHERE isdelete=0 GROUP BY years,months";
		$files=Blog::query($sql);
		return $files; 
	}

	/**
	 * 具体一段时间的文章
	 * @param string $date [时间 年/月]
	 * @return array
	*/
	public static function findDate($date)
	{
		$sql="SELECT * FROM tp_blog WHERE FROM_UNIXTIME(addtime,'%Y%m')='$date'  AND `isdelete` = 0 ORDER BY addtime desc LIMIT 0,10";
		// $files=Blog::query($sql);
		$files=Blog::where('FROM_UNIXTIME(addtime,"%Y%m")='.$date)
					->where('isdelete=0')
					->order('addtime desc')
					->paginate(10);
		return $files; 
	}

	/**
     * 获取总的分类即博客数目
     * @param string $name[skill/life]
     * @return array [0]=>('sort'=>javascript 'count'=>3)
	*/
	public static function sort()
	{
		$list=Blog::field('sort,COUNT(*) as count')
					->where('isdelete',0)
					->group('sort')
					->select();
		return $list;
	}

	/**
	 * 分类博客
	 * @param string $sort [分类名称]
	 * @return array [相关博客列表]
	 */
	public static function getSort($sort)
	{
		$list=Blog::where('isdelete',0)
					->where('sort like :word')
					->bind(['word'=>"$sort"])
					->order('addtime desc')
					->paginate(10);
		return $list;
	}

}