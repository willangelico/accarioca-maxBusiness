        <header>
            <button id="nav-mobile">
                <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
            </button>
           <?php if ($this->page == 'home'){?>
                <h1>
                    <a href="/" title="<?=NAME;?>">
                        <img src="<?=HOME_URI;?>public/images/logo.jpg" alt="AC Carioca">
                    </a>
                </h1>
            <?php }else{?>            
                <a href="/" id="logo" title="<?=NAME;?>">
                    <img src="<?=HOME_URI;?>public/images/logo.jpg" alt="AC Carioca">
                </a>    
            <?php }?>
            <nav>
                <ul>
                    <li><a href="/" <?=($this->page=='home') ? 'class="active"' : '';?>>Home</a></li>
                    <li><a href="/materiais" <?=($this->page=='materiais') ? 'class="active"' : '';?>>Materiais</a></li>
                    <li><a href="/servicos" <?=($this->page=='servicos') ? 'class="active"' : '';?>>Serviços</a></li>
                    <li><a href="/orcamento" <?=($this->page=='orcamento') ? 'class="active"' : '';?>>Orçamento</a></li>
                    <li><a href="/contato" <?=($this->page=='contato') ? 'class="active"' : '';?>>Contato</a></li>
                </ul>
               <!--  <form action="/materiais" method="get" class="form-inline" id="form-search">
                    <fieldset class="form-group">
                        <label class="sr-only" for="search-ipt">O que você está procurando?</label>
                        <div class="input-group">
                            <input type="text" name="busca" id="search-ipt" class="header-search form-control" placeholder="O que você está procurando?" />
                        </div>
                        <button class="btn" type="submit"><i class="fa fa-search fa-2" aria-hidden="true"></i></button>
                    </fieldset>
                </form>   -->                           
            </nav>
        </header>