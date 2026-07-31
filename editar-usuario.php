<h1>Editar Usuario</h1>
<?php
	$sql = "SELECT * FROM usuario WHERE id_usuario=".$_GET["id_usuario"];

	$res = $conn->query($sql);

	$row = $res->fetch_object();
?>
<form action="?page=salvar-usuario" method="POST">
	<input type="hidden" name="acao" value="editar">
	<input type="hidden" name="id_usuario" value="<?php print $row->id_usuario; ?>">
	<div class="mb-3">
    <label>Nome do usuario</label>
    <input type="text" name="nome_usuario" value="<?php print $row->nome_usuario; ?>" class="form-control">
</div>
	<div class="mb-3">
    <label>E-mail do usuario</label>
    <input type="email" name="email_usuario" value="<?php print $row->email_usuario; ?>" class="form-control">
</div>	

<div class="mb-3">
    <label>Senha</label>
    <input type="text" name="senha_usuario" value="<?php print $row->senha_usuario; ?>" class="form-control">
</div>

<div class="mb-3">
    <label>Nível de Acesso</label>
    <select name="nivel_usuario" class="form-select">
        <option value="Cliente" <?php echo ($row->nivel_usuario == 'Cliente') ? 'selected' : ''; ?>>Cliente</option>
        <option value="Operador" <?php echo ($row->nivel_usuario == 'Operador') ? 'selected' : ''; ?>>Operador</option>
        <option value="Admin" <?php echo ($row->nivel_usuario == 'Admin') ? 'selected' : ''; ?>>Admin</option>
    </select>
</div>

<div class="mb-3">
    <label>Prioridade de Atendimento</label>
    		<select name="prioridade_atendimento" class="form-select">
			<option value="1" <?php print($row->prioridade_atendimento==1?"selected":""); ?>>Nível 1</option>
			<option value="2" <?php print($row->prioridade_atendimento==2?"selected":""); ?>>Nível 2</option>
			<option value="3" <?php print($row->prioridade_atendimento==3?"selected":""); ?>>Nível 3</option>
			<option value="4" <?php print($row->prioridade_atendimento==4?"selected":""); ?>>Nível 4</option>
			<option value="5" <?php print($row->prioridade_atendimento==5?"selected":""); ?>>Nível 5</option>
		</select>
</div>

<div class="mb-3">
    <button type="submit" class="btn btn-primary">Salvar Edição</button>
</div>
</form>