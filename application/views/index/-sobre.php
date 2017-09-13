    <?Php foreach($paginas as $p){ ?>
		<div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" id="sobre">
                        <div class="page-header">
                            <h1>sobre mim
                                <small>/ estefan bombonato</small>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section section-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img src="<?=HOME_URI;?>public/files/images/pages/<?=$p['url_img']?>?<?=rand(0,99);?>" class="img-responsive" style="padding:30px;">
                    </div>
                    <div class="col-md-6">
                        <h1><?=$p['title'];?></h1>
                        <h3><?=$p['caption'];?></h3>
                        <?=$p['content'];?>                        
                    </div>
                </div>
            </div>
        </div>
    <?Php }?>