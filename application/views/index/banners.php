<section id="home" class="">
	<div class="container">
        <div id="myCarousel" class="carousel slide" data-ride="carousel"> 
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?Php for ($i=0; $i < count($banners); $i++) { ?>
                    <li data-target="#myCarousel" data-slide-to="0" <?= $i==0 ? 'class="active"' : '';?>></li>
                <?php }?>	    
            </ol>
            <div class="carousel-inner">
                <?Php $i=0; foreach($banners as $b){ ?>
                    <div class="item <?= $i==0 ? 'active' : '';?>"> <img src="<?=HOME_URI;?>public/files/images/banners/mini/<?=$b['url_img']?>?<?=rand(0,99);?>" style="width:100%" alt="<?=$b['titulo'];?>">
                        <div class="container">
                            <div class="carousel-caption">
                                <h1><?=$b['titulo'];?></h1>
                                <p><?=$b['legenda'];?></p>
                                <p><?php if($b['url']){?><a class="btn btn-lg btn-primary scroll" href="<?=$b['url'];?>" role="button">Veja as fotos</a><?php } ?></p>
                            </div>
                        </div>
                    </div>
                <?php $i++; }?>
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
	</div>
</section>
