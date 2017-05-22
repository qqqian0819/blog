<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:60:"D:\www\blog\public/../application/index\view\index\home.html";i:1495461136;s:62:"D:\www\blog\public/../application/index\view\index\header.html";i:1495461195;s:62:"D:\www\blog\public/../application/index\view\index\footer.html";i:1495462366;}*/ ?>
<!-- 公共头部 -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>技术</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="/blog/public/favicon.png">
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_root'); ?>css/header.css">
<link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_root'); ?>css/home.css">
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
	<!-- 博客 -->
	<div id="blog">
		<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$bl): $mod = ($i % 2 );++$i;?>
		<div class="item">

			<strong><a href="detail?id=<?php echo $bl['id']; ?>"><?php echo $bl['title']; ?></a></strong>
			<p><?php echo date("Y-m-d H:i:s",$bl['addtime']); ?>&nbsp;&nbsp;<strong>分类：</strong><?php echo $bl['sort']; ?></p>
			<div class="text"><?php echo $bl['content']; ?></div>
			<p class="readAll"><a href="detail?id=<?php echo $bl['id']; ?>">-阅读全文-</a></p>
		</div>
		<?php endforeach; endif; else: echo "$empty" ;endif; ?>

		<div class="pages"><?php echo $list->render(); ?></div>
	</div>
	<!-- 分类 -->
	<div class="sort">
		<div>
			<strong>分类列表</strong>
			<ul>
				<?php if(is_array($sorts) || $sorts instanceof \think\Collection || $sorts instanceof \think\Paginator): $i = 0; $__LIST__ = $sorts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$so): $mod = ($i % 2 );++$i;?>
				<li><a href="sort?sort=<?php echo $so['sort']; ?>"><?php echo $so['sort']; ?>(<?php echo $so['count']; ?>)</a></li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<hr>
		<div>
			<strong>文章存档</strong>
			<ul>
				<?php if(is_array($files) || $files instanceof \think\Collection || $files instanceof \think\Paginator): $i = 0; $__LIST__ = $files;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fi): $mod = ($i % 2 );++$i;?>
				<li><a href="dateSort?date=<?php echo $fi['years']; ?><?php echo $fi['months']; ?>"><?php echo $fi['years']; ?>年<?php echo $fi['months']; ?>月(<?php echo $fi['num']; ?>)</a></li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
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
</body>
</html>
