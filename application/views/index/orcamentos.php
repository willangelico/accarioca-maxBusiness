<main>
			<div class="container-fluid">
				<div class="row">
                    <div class="col-md-offset-3 col-md-6">
                        <h1>Orçamento</h1>
                        <p>Realize a <strong>festa</strong> dos seus sonhos. Solicite seu orçamento, sem compromisso e se surpreenda com nossos produtos.</p>
                    </div>		
				</div>
                <div class="row">
                    <div class="col-md-3">
                        <img src="/public/images/budget.jpg" alt="Solicite seu orçamento" />
                    </div>
                    <div class="col-md-9">
                        <form action="<?=HOME_URI;?>contato" method="POST" role="form" id="budget-form">
                            <div class="form-group col-md-6">
                                <label for="name" class="sr-only">Nome</label>
                                <input type="text" class="form-control" id="name" placeholder="Nome">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="sr-only">E-mail</label>
                                <input type="text" class="form-control" id="email" placeholder="E-mail">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone" class="sr-only">Telefone</label>
                                <input type="text" class="form-control" id="phone" placeholder="Telefone">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date" class="sr-only">Data do Evento</label>
                                <input type="text" class="form-control" id="date" placeholder="Data do Evento">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="place" class="sr-only">Local</label>
                                <input type="text" class="form-control" id="place" placeholder="Local">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type" class="sr-only">Tipo do Evento (Casamento, Aniversário, etc...)</label>
                                <input type="text" class="form-control" id="type" placeholder="Tipo do Evento (Casamento, Aniversário, etc...)">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="obs" class="sr-only">Observações</label>
                                <textarea id="obs" class="form-control" rows="3" required="required" placeholder="Observações"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
			</div>
		</main>