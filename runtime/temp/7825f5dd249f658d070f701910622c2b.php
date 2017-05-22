<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:62:"D:\www\blog\public/../application/index\view\index\detail.html";i:1495462952;s:62:"D:\www\blog\public/../application/index\view\index\header.html";i:1495461195;s:66:"D:\www\blog\public/../application/index\view\index\messlayout.html";i:1495468135;s:62:"D:\www\blog\public/../application/index\view\index\footer.html";i:1495462366;}*/ ?>
<!-- 公共头部 -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>xianga</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="/blog/public/favicon.png">
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_root'); ?>css/header.css">
<link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_root'); ?>css/detail.css">
</head>
<body>
<header>
	<p><h2><a href="home">媛界码萌</a></h2></p>
</header>
<nav class="navbar navbar-default container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>

        </button>
        <a class="navbar-brand" href="home">个人博客</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="home">技术</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="message">留言</a>
            </li>        
        </ul>
        <form class="navbar-form navbar-right" method="post" action="search">
            <div class="form-group">
                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search">
            </div>
             <button type="submit" class="btn btn-default">Search</button>
        </form>
    </div>
</nav> 
<main class="container">
	<div class="item">
		<strong><?php echo $blog['title']; ?></strong>
		<p><?php echo date("Y-m-d H:i:m",$blog['addtime']); ?><strong> 分类：</strong><?php echo $blog['sort']; ?></p>
		<div class="text">
			<?php echo $blog['content']; ?>
		</div>
	</div>
	<hr>
	<div class="other">
		<span>上一篇：<em><a href="detail?id=<?php echo $blog['pre'][0]['id']; ?>"><?php echo $blog['pre'][0]['title']; ?></a></em></span>
		<span class="pull-right">下一篇：<em><a href="detail?id=<?php echo isset($blog['next'][0]['id']) ? $blog['next'][0]['id'] : $blog['id']; ?>"><?php echo isset($blog['next'][0]['title']) ? $blog['next'][0]['title'] : '暂无相关博客'; ?></a></em></span>
		<hr>
		<h3>添加评论</h3>
		<!-- 评论留言样式 -->
<form name="form0">
	<input type="hidden" name="blog" value="<?php echo $blog['id']; ?>">
	<div class="form-group">
		<label for="name">称呼(必填)：</label>
		<input type="text" placeholder="请输入用户名" id="name" name="name" class="form-control"/>
	</div>
	<div class="form-group">
		<label for="email">邮箱(不会被公开)：</label>
		<input type="email" placeholder="如果不介意留下您的联系方式吧" id="email" name="email" class="form-control"/>
	</div>
	<div>
		<label for="message">内容(必填)：</label>
		<textarea name="message" id="message" class="form-control" rows="5" placeholder="输入你相对我说的话吧"></textarea>
	</div>
	<br>
	<button id="mess" class="btn btn-default btn-lg btn-block" >留 言</button>
	
</form>
<hr>
<h3>评论列表(<span style="color:#f00"><?php echo count($list); ?></span>)</h3>
<div class="list">
<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>	
	<?php echo $vo['border']; ?>
	<div style="background:<?php echo $vo['bg']; ?>;margin-left:<?php echo $vo['lefts']; ?>em">
		<strong><?php echo isset($vo['name']) ? $vo['name'] : '匿名'; ?></strong>
		<p class="time"><?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></p>
		<div class="text">
			<?php echo $vo['message']; ?>
		</div>
		<p class="comment">回复</p>
		<form name="form<?php echo $vo['id']; ?>">
			<input type="hidden" value="<?php echo $vo['id']; ?>" />
		</form>
	</div>
<?php endforeach; endif; else: echo "$empty" ;endif; ?>
</div>


	</div>
</main>
<!-- 公共页脚 -->
<div style="clear:both"></div>
<footer>
	<hr>
	<p class="text-center">Powered & designed by qqqian</p>
	<p class="text-center">Copyright @ 2017 qqqian</p>
</footer>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
	$(function(){
		let contentHeight = document.body.scrollHeight,//网页正文全文高度
            winHeight = window.innerHeight;//可视窗口高度，不包括浏览器顶部工具栏
        if(!(contentHeight > winHeight)){
            $("footer").css({'position':' fixed','bottom': 0,'width':'100%'});
            // $("footer").css({'position':' fixed','bottom': 0});
            // $("footer").css({'bottom': 0,'width':'100%'});
        }
	});

</script>
<script type="text/javascript" src="/blog/public/static/editor/third-party/SyntaxHighlighter/shCore.js"></script>
<script src="<?php echo \think\Config::get('web_root'); ?>js/message.js"></script>
<script>SyntaxHighlighter.highlight();</script>
</body>
</html>