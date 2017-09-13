		<div class="section" id="trabalhos">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h1>trabalhos recentes
                                <small> / últimos trabalhos</small>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="background-image" ></div>
            <div class="container">
                <div class="row">
                    <?Php foreach($recentes as $r){ ?>
                        <div class="col-md-4">
    						<a href="<?=HOME_URI;?><?=seo($r['category']);?>/<?=seo($r['titulo']);?>-<?=$r['id_galerias'];?>" class="gal_item" title="<?=$r['titulo'];?>" >
    							<img title="<?=$r['titulo'];?>" alt="<?=$r['titulo'];?>" src="<?=HOME_URI;?>public/files/images/galerias/mini/<?=$r['cover']?>?<?=rand(0,99);?>">
    							<div class="gal_caption"><?=$r['titulo'];?></div>
    							<span class="gal_magnify"></span>
    						</a>
                        </div>
                    <?Php }?>
                </div>

            </div>
        </div>