<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="m-0">Cardápio</h1>
    <button class="btn btn-primary" onclick="openCardapioModal()">+ Cadastrar Novo</button>
</div>
<?php
$sql = "SELECT * FROM cardapio";
$res = $conn->query($sql);
$qtd = $res->num_rows;

if ($qtd > 0) {
    print "<p>Encontrou <b>$qtd</b> resultado(s)</p>";

    print "<div class='table-responsive'><table class='table table-bordered table-striped table-hover'>";
    print "<tr>";
    print "<th>#</th>";
    print "<th>Nome</th>";
    print "<th>Categoria</th>";
    print "<th>Situação</th>";
    print "<th>Ações</th>";
    print "</tr>";
    while ($row = $res->fetch_object()) {
        print "<tr>";
        print "<td>" . $row->id_cardapio . "</td>";
        print "<td>" . $row->nome_cardapio . "</td>";
        print "<td>" . $row->categoria_cardapio . "</td>";
        print "<td>" . $row->situacao_cardapio . "</td>";
        print "<td>
					<button class='btn btn-success' onclick=\"location.href='?page=editar-cardapio&id_cardapio=" . $row->id_cardapio . "';\">Editar</button>

					<button class='btn btn-danger' onclick=\"confirmDelete('?page=salvar-cardapio&acao=excluir&id_cardapio=" . $row->id_cardapio . "')\">Excluir</button>
				   </td>";
        print "</tr>";
    }
    print "</table></div>";
} else {
    print "<p class='alert alert-warning'>Não encontrou resultados!</p>";
}
?>


<div id="sheetBackdropCardapio" class="sheet-backdrop" onclick="closeCardapioModal()"></div>
<div id="detailsModalCardapio" class="bottom-sheet">
    <div class="bottom-sheet-header">
        <div class="bottom-sheet-drag-handle"></div>
        <h5 class="mb-0">Cadastrar Item no Cardápio</h5>
    </div>
    <div class="bottom-sheet-content">
        <form action="?page=salvar-cardapio" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="acao" value="cadastrar">
            <div class="mb-3">
                <label class="form-label">Nome do item</label>
                <input type="text" name="nome_cardapio" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select name="categoria_cardapio" class="form-select" required>
                    <option value="Bebida">Bebida</option>
                    <option value="Lanche">Lanche</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Foto do Item (Opcional)</label>
                <input type="file" name="imagem_arquivo" class="form-control" accept="image/*" capture="environment">
            </div>
            <div class="mb-4">
                <label class="form-label">Situação</label>
                <select name="situacao_cardapio" class="form-select" required>
                    <option value="Ativo">Ativo (Disponível)</option>
                    <option value="Inativo">Inativo (Indisponível)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-3">Salvar Item</button>
            <button type="button" class="btn btn-outline-secondary w-100 py-2 mt-2"
                onclick="closeCardapioModal()">Cancelar</button>
        </form>
    </div>
</div>

<script>
    function openCardapioModal() {
        document.getElementById('detailsModalCardapio').classList.add('open');
        document.getElementById('sheetBackdropCardapio').classList.add('open');
    }

    function closeCardapioModal() {
        document.getElementById('detailsModalCardapio').classList.remove('open');
        document.getElementById('sheetBackdropCardapio').classList.remove('open');
    }
</script>