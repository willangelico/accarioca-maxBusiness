        <div class="section" id="trabalhos">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h1><a href="<?=HOME_URI;?><?=seo($lista['categoria']['titulo']);?>-<?=$lista['categoria']['id_galerias_categorias']?>"><?=$lista['categoria']['titulo'];?></a>
                                <small> / <a href="<?=HOME_URI;?>album">álbuns</a></small>
                            </h1>
                            <h2><?=$lista['galeria']['titulo'];?></h2>
                            <h3><?=$lista['galeria']['chamada'];?></h3>
                            <div><?=stripslashes($lista['galeria']['conteudo']);?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row fotos">
                    <?Php foreach($lista['fotos'] as $f){ ?>
                        <div class="col-md-12 thumbnail">
    						<img title="<?=$lista['galeria']['titulo'];?>" alt="<?=$lista['galeria']['titulo'];?>" src="<?=HOME_URI;?>public/files/images/galerias/<?=$f['url_img']?>?<?=rand(0,99);?>">
    						</a>
                        </div>
                    <?Php }?>
                </div>
                <div class="row">
                    <div class="fb-comments" width="100%" data-href="http://<?=$_SERVER['SERVER_NAME'];?><?=$_SERVER ['REQUEST_URI'];?>" data-numposts="5" data-colorscheme="light"></div>
                </div>
            </div>
        </div>