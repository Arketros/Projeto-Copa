<h1>Editar Cardápio</h1>
<?php
	$sql = "SELECT * FROM cardapio WHERE id_cardapio =".$_REQUEST["id_cardapio"];

	$res = $conn->query($sql);

	$row = $res->fetch_object();
?>
<form action="?page=salvar-cardapio" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="acao" value="editar">
	<input type="hidden" name="id_cardapio" value="<?php print $row->id_cardapio; ?>">
	<div class="mb-3">
		<label>Nome do item</label>
		<input type="text" name="nome_cardapio" value="<?php print $row->nome_cardapio; ?>" class="form-control" required>
	</div>
    <div class="mb-3">
        <label>Categoria</label>
        <select name="categoria_cardapio" class="form-select" required>
            <option value="Bebida" <?php echo ($row->categoria_cardapio == 'Bebida') ? 'selected' : ''; ?>>Bebida</option>
            <option value="Lanche" <?php echo ($row->categoria_cardapio == 'Lanche') ? 'selected' : ''; ?>>Lanche</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Foto do Item (Opcional - deixe vazio para manter atual)</label>
        <?php if (!empty($row->imagem_url)): ?>
            <div class="mb-2">
                <img src="<?php print $row->imagem_url; ?>" style="max-height: 80px; border-radius: 8px;">
            </div>
        <?php endif; ?>
        <input type="file" name="imagem_arquivo" class="form-control" accept="image/*" capture="environment">
    </div>

	<div class="mb-3">
    <label>Situação</label>
    <select name="situacao_cardapio" class="form-select">
        <option value="Ativo" <?php echo ($row->situacao_cardapio == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
        <option value="Inativo" <?php echo ($row->situacao_cardapio == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
    </select>
</div>
<div class="mb-3">
    <button type="submit" class="btn btn-primary">Salvar Edição</button>
</div>
</form>