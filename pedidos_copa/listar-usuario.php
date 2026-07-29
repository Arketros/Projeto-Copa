<h1>Listar Usuário</h1>
<?php
	$sql = "SELECT * FROM usuario";
	$res = $conn->query($sql);
	$qtd = $res->num_rows;

	if($qtd > 0){
		print "<p>Encontrou <b>$qtd</b> resultado(s)</p>";

		print "<table class='table table-bordered table-striped table-hover'>";
		print "<tr>";
		print "<th>#</th>";
		print "<th>Nome do Usuario</th>";
		print "<th>E-mail</th>";
		print "<th>Senha</th>";
		print "<th>Ações</th>";
		print "</tr>";
		while($row = $res->fetch_object()){
			print "<tr>";
			print "<td>".$row->id_usuario."</td>";
			print "<td>".$row->nome_usuario."</td>";
			print "<td>".$row->email_usuario."</td>";
			print "<td>".$row->senha_usuario."</td>";
			print "<td>
					<button class='btn btn-success' onclick=\"location.href='?page=editar-usuario&id_usuario=".$row->id_usuario."';\">Editar</button>

					<button class='btn btn-danger' onclick=\"
						if(confirm('Tem certeza que deseja excluir?')){
							location.href='?page=salvar-usuario&acao=excluir&id_usuario=".$row->id_usuario."';
						}else{
							false;
						}\">Excluir</button>
				   </td>";
			print "</tr>";
		}
		print "</table>";

	}else{
		print "Nenhum resultado";
	}