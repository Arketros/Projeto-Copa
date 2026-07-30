<h1>Editar Sala</h1>
<?php
	$sql = "SELECT * FROM sala WHERE id_sala=".$_REQUEST["id_sala"];
	$res = $conn->query($sql);
	$row = $res->fetch_object();
?>
<form action="?page=salvar-sala" method="POST">
	<input type="hidden" name="acao" value="editar">
	<input type="hidden" name="id_sala" value="<?php print $row->id_sala; ?>">
	<div class="mb-3">
		<label>Nome da Sala</label>
		<input type="text" name="nome_sala" value="<?php print $row->nome_sala; ?>" class="form-control" required>
	</div>
	<div class="mb-3">
		<label>Capacidade (Quantidade de Cadeiras)</label>
		<input type="number" name="capacidade" class="form-control" min="1" value="<?php print isset($row->capacidade) ? $row->capacidade : 6; ?>" required>
	</div>
	<div class="mb-3">
		<button type="submit" class="btn btn-primary">Salvar Edição</button>
	</div>
</form>
