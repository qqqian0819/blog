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
					->order('addtime desc')->paginate(10);
		return $files; 
	}

	/**
     * 生活或者技术分类
     * @param string $name[skill/life]
     * @return array [0]=>('sort'=>javascript 'count'=>3)
	*/
	public static function sort($name)
	{
		$list=Blog::field('tp_sort.sort,COUNT(*),s.name')
					->alias('b')
					->join('tp_sort s','b.sort=s.id')
					->where('isdelete',0)
					// ->having('s.name='.$name)
					->group('s.sort')
					->select();

		return $list;
	}

}