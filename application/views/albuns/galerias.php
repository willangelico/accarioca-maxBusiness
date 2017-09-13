        <div class="section" id="trabalhos">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h1><a href="<?=HOME_URI;?><?=seo($lista['categoria']['titulo']);?>-<?=$lista['categoria']['id_galerias_categorias']?>"><?=$lista['categoria']['titulo'];?></a>
                                <small> / <a href="<?=HOME_URI;?>album">materiais</a></small>
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
                    <?Php foreach($lista['galerias'] as $g){ ?>
                        <div class="col-md-4">
    						<a href="<?=HOME_URI;?><?=seo($lista['categoria']['titulo']);?>/<?=seo($g['titulo']);?>-<?=$g['id_galerias'];?>" class="gal_item" title="<?=$g['titulo'];?>" >
    							<img title="<?=$g['titulo'];?>" alt="<?=$g['titulo'];?>" src="<?=HOME_URI;?>public/files/images/galerias/mini/<?=$g['cover']?>?<?=rand(0,99);?>">
    							<div class="gal_caption"><?=$g['titulo'];?></div>
    							<span class="gal_magnify"></span>
    						</a>
                        </div>
                    <?Php }?>
                </div>

            </div>
        </div>