<?php
namespace app\common\model;
use think\input;
use think\Model;
class Message extends Model
{

	/**
	 * 增添留言
	 * @param array
	 * @return bool
	*/
	public static function addMessage($data)
	{
		$data['addtime']=time();
		return $res=Message::create($data);
	}

	/**
     * 获取博客的评论
	 * @param int $blog [博客的id]
	 * @return array  
	*/
	public static function blogMess($blog){
		$arr=Message::where("blog=$blog and isdelete=0")->select();
		$list=Message::getTree($arr);
		return $list;
	}


	/**
	 * 获取所有未被删除的留言及其所有的评论回复之类：isdelete=0 && blog=0
	 * @return array
	*/
	public static function getAll()
	{
		$arr=Message::where('isdelete=0 and blog=0')->select();
		$list=Message::getTree($arr,0);
		return $list;
	} 


	/**
	 * 递归获取留言家谱树
	 * @param array $arr [第一次传入的数组是左右留言数据]
	 * @param int $id [需要获取家谱的第一代id]
	 * @param int $lev [第几代]
	 * @return array $tree
	 		array([0]=>([id] =>)
                  [1]=>([id] =>)
                )
	*/
	public static function getTree($arr,$id = 0,$lev=0)
	{
		$tree=array();
		foreach($arr as $v){
			if($v['parent']==$id){
				$v['lev']=$lev;
				$tree[]=$v;
				$tree = array_merge($tree,Message::getTree($arr,$v['id'],$lev+1));
			}
		}
		return $tree;
	}



	/**
	 * 软删除留言及其子孙留言
	 * @param int $id [要删除的留言的id]
	 * @return bool
	*/
	public static function delMess($id)
	{	
		Message::where('id',$id)->update(['isdelete'=>1]);
		$arr=Message::field('id,parent')->where([])->select();
		$list=Message::getTree($arr,$id);
		// 遍历删除子孙
		foreach ($list as $v) {
			Message::where('id',$v['id'])->update(['isdelete'=>1]);
		}
		return true;
		
	}

}