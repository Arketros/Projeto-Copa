<h1>Cadastrar Usuario</h1>
<form action="?page=salvar-usuario" method="POST">
	<input type="hidden" name="acao" value="cadastrar">
	<div class="mb-3">
		<label>Nome</label>
		<input type="text" name="nome_usuario" class="form-control">
	</div>
	<div class="mb-3">
		<label>E-mail</label>
		<input type="text" name="email_usuario" class="form-control">
	</div>	
	<div class="mb-3">
		<label>Senha</label>
		<input type="text" name="senha_usuario" class="form-control">
	</div>
	<div class="mb-3">
		<button type="submit" class="btn btn-primary">Enviar</button>
	</div>	
</form>