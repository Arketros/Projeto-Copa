<h1>Editar Cardápio</h1>
<?php
	$sql = "SELECT * FROM cardapio WHERE id_cardapio =".$_REQUEST["id_cardapio"];

	$res = $conn->query($sql);

	$row = $res->fetch_object();
?>
<form action="?page=salvar-cardapio" method="POST">
	<input type="hidden" name="acao" value="editar">
	<input type="hidden" name="id_cardapio" value="<?php print $row->id_cardapio; ?>">
	<div class="mb-3">
		<label>Nome do item</label>
		<input type="text" name="nome_cardapio" value="<?php print $row->nome_cardapio; ?>" class="form-control" required>
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