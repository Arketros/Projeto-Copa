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
    <button type="submit" class="btn btn-primary">Salvar Edição</button>
</div>
</form>