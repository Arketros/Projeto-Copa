<h1>Cadastrar Cardápio</h1>
<form action="?page=salvar-cardapio" method="POST">

	<input type="hidden" name="acao" value="cadastrar">
	<div class="mb-3">
		<label>Nome do item</label>
		<input type="text" name="nome_cardapio" class="form-control" required>
	</div>

	<div class="mb-3">
		<label>Situação</label>
		<select name="situacao_cardapio" class="form-select" required>
			<option value="">Selecione uma opção</option>
            <option value="Disponível">Disponível</option>
            <option value="Indisponível">Indisponível</option>
        </select>
    </div>	

	<button type="submit" class="btn btn-primary">
		Enviar
	</button>
</form>