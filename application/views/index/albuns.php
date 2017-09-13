		<div class="section" id="trabalhos">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h1>trabalhos
                                <small>/ álbuns</small>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="background-image" style="background: rgba(0, 0, 0, 0) url('<?=HOME_URI;?>public/images/bg.jpg') repeat scroll 0 0;"></div>
            <div class="container">
                <div class="row">
                    <?Php foreach($categorias as $c){ ?>
                        <div class="col-md-6">
    						<a class="gal_item" title="<?=$c['titulo'];?>" href="<?=HOME_URI;?><?=seo($c['titulo']);?>-<?=$c['id_galerias_categorias']?>">
    							<img title="<?=$c['titulo'];?>" alt="<?=$c['titulo'];?>" src="<?=HOME_URI;?>public/files/images/galerias/mini/<?=$c['url_img']?>?<?=rand(0,99);?>">
    							<div class="gal_caption"><?=$c['titulo'];?></div>
    							<span class="gal_magnify"></span>
    						</a>
                        </div>
                    <?Php } ?> 
                </div>
            </div>
        </div>