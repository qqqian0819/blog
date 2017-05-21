;
	// 评论回复框弹出与取消
	$('.comment').on('click',function(){

		if($(this).next().find('label').text()==''){
			var form='<div class="form-group"><label for="name">称呼(必填)：</label><input type="text" placeholder="请输入用户名" id="name" name="name" class="form-control"/></div><div class="form-group"><label for="email">邮箱(不会被公开)：</label><input type="text" placeholder="如果不介意留下您的联系方式吧" id="email" name="email" class="form-control"/></div><div><label for="message">内容(必填)：</label><textarea name="message" id="message" class="form-control" rows="5" placeholder="输入你相对我说的话吧"></textarea></div><br><button class="btn btn-outline-info btn-block" type="submit">回复</button>';
		
			$(this).next().append(form); // 添加form到子节点尾部
			$(this).text('取消回复');
		}else{
			// .first() 无效???
			$(this).next().find('input[type=hidden]').nextAll().remove();
			$(this).text('回复');

			
		}

	});

	// 提交留言
	$('#mess').on('click',function(){

		let data=$('form').serialize();
		console.log(data);
		getAjax(data,'addComment');

		return false;
	});

	// 评论回复留言
	$('form').submit(function(e){

		let num=$(this).find('input[type=hidden]').val();
		
		// 拼装数据
		let data=$('form[name=form'+num+']').serialize()+'&parent='+num+'&blog='+{$id};
		
		getAjax(data,'addComment');
		return false;
	});

	// 调用jax
	function getAjax($data,$url){
		$.ajax({
			url:$url,
			method:'POST',
			data:$data
		})
		.done(function(msg){
			console.log('成功'+msg);
			document.location.reload();//刷新当前页面
		})
		.fail(function(msg){
			console.log('sorry 再试一次吧');
		});
	}