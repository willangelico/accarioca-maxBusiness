<!DOCTYPE html>
<html lang="pt-br">
	<head>	

		<meta charset="utf-8">
		<title><?=$this->title;?></title>		
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Maxwill Estúdio Web">
		<meta name="reply-to" content="contato@maxwill.com.br">  
		<meta name="description" content="<?=$this->description;?>">
	  	<meta name="keywords" content="<?=$this->keywords;?>">	
	  	<meta name="robots" content="index,follow">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">	  	
	  	<meta http-equiv="content-language" content="pt-br">

		<meta property="og:locale" content="pt-BR" />
        <meta property="og:url" content="<?=URL;?>" />
        <meta property="og:title" content="<?=$this->title;?>" />
    	<meta property="og:site_name" content="<?=NAME;?>" />
		<meta property="og:description" content="<?=$this->description;?>" />    
		<meta property="og:image" content="<?=$this->meta_img;?>" />     
        <link rel="shortcut icon" href="/public/icons/favicon.ico" type="image/x-icon" />
	  	<link href="<?=HOME_URI;?>public/styles/bootstrap.min.css" rel="stylesheet">		             
        <link href="<?=HOME_URI;?>public/styles/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="<?=HOME_URI;?>public/styles/style.css" rel="stylesheet">
	</head>
	<body>
        <!-- Google Tag Manager -->
        <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5QLQMT"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5QLQMT');</script>
        <!-- End Google Tag Manager -->    
		<div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=311884268972666&version=v2.0";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>