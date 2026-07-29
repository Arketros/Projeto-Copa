<h1>Listar Cardápio</h1>
<?php
	$sql = "SELECT * FROM cardapio";
	$res = $conn->query($sql);
	$qtd = $res->num_rows;

	if($qtd > 0){
		print "<p>Encontrou <b>$qtd</b> resultado(s)</p>";

		print "<table class='table table-bordered table-striped table-hover'>";
		print "<tr>";
		print "<th>#</th>";
		print "<th>Nome da cardapio</th>";
		print "<th>Situação do Item</th>";
		print "<th>Ações</th>";
		print "</tr>";
		while($row = $res->fetch_object()){
			print "<tr>";
			print "<td>".$row->id_cardapio."</td>";
			print "<td>".$row->nome_cardapio."</td>";
			print "<td>".$row->situacao_cardapio."</td>";
			print "<td>
					<button class='btn btn-success' onclick=\"location.href='?page=editar-cardapio&id_cardapio=".$row->id_cardapio."';\">Editar</button>

					<button class='btn btn-danger' onclick=\"
						if(confirm('Tem certeza que deseja excluir?')){
							location.href='?page=salvar-cardapio&acao=excluir&id_cardapio=".$row->id_cardapio."';
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