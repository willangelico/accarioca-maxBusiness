        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" id="contato">
                        <div class="page-header">
                            <h1>contato
                                <small>/ solicite um orçamento</small>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="background-image" style="background: rgba(0, 0, 0, 0) url('<?=HOME_URI;?>public/images/bg.jpg') repeat scroll 0 0;"></div>

 <!--           <div class="background-image background-image-fixed" style="background-image : url('http://estefanbombonato.com.br/public/files/images/galerias/wedding-_-isabela-amp-felipe520556.jpg')"></div>
 -->           <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="well">
                            <h2>Estefan Bombonato Photography.</h2>
                            <p>Fones: (14) 9-8109.0006 / (14)9-8133.3711
                                <br>E-mail:
                                <a href="#">estefanbombonato@hotmail.com</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="<?=HOME_URI;?>contato" method="post" role="form" class="text-right" id="form-contact">
                            <div id="form-msg"></div>
                            <div class="form-group has-feedback">
                                <input class="form-control input-lg" name="name" id="name" placeholder="insira seu nome"
                                type="text" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-lg" name="email" id="email" placeholder="Insira seu e-mail"
                                type="email" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-lg" name="phone" id="phone" placeholder="Insira seu telefone"
                                type="text" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control input-lg" name="message" id="message" placeholder="Insira sua mensagem" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-lg btn-primary" id="send-form">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>