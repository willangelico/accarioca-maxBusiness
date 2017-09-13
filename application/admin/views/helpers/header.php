<!DOCTYPE html>
<html lang="pt-br">
	<head>	
		<meta charset="utf-8" />
		<title><?=$this->title;?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<meta name="author" content="Maxwill Estúdio Web" />
		<meta name="reply-to" content="contato@maxwill.com.br" />
	  	<meta name="description" content="<?=$this->description;?>" />
	  	<meta name="keywords" content="<?=$this->keywords;?>" />	
	  	<meta name="robots" content="index,follow" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />	  	
	  	<meta http-equiv="content-language" content="pt-br" />
		<link rel="stylesheet" type="text/css" href="<?=HOME_URI;?>public/styles/bootstrap.min.css" />
    	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />		
		<link rel="stylesheet" type="text/css" href="<?=HOME_URI;?>public/admin/styles/style.css" />
		<link rel="stylesheet" type="text/css" href="<?=HOME_URI;?>public/plugins/iCheck/square/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?=HOME_URI;?>public/plugins/bootstrap-daterangepicker-master/daterangepicker-bs3.css" />
		<link rel="stylesheet" type="text/css" href="<?=HOME_URI;?>public/plugins/Simple-Ajax-Uploader-master/assets/css/styles.css" />
		<link rel="stylesheet" type="text/css" href="<?=HOME_URI;?>public/plugins/fancyapps-fancyBox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?=HOME_URI;?>public/plugins/fancyapps-fancyBox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5"  media="screen" />
		<link rel="stylesheet" type="text/css" href="<?=HOME_URI;?>public/plugins/fancyapps-fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?=HOME_URI;?>public/plugins/Jcrop/css/jquery.Jcrop.css" />		
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body class="<?=$this->body_class;?>">
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.3&appId=249483435193590";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>