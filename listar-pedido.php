<h1>Listar Pedidos</h1>
<?php
	$sql = "SELECT p.*, c.nome_cardapio 
			FROM pedido AS p
			INNER JOIN cardapio AS c 
			ON p.cardapio_id_cardapio = c.id_cardapio";
			
	$res = $conn->query($sql);
	$qtd = $res->num_rows;

	if($qtd > 0){
		print "<p>Encontrou <b>$qtd</b> resultado(s)</p>";
		print "<table class='table table-bordered table-striped table-hover'>";
		print "<tr>";
		print "<th>#</th>";
		print "<th>Nome do pedido</th>";
		print "<th>Quantidade</th>";
		print "<th>Ações</th>";
		print "</tr>";
		while($row = $res->fetch_object()){
			print "<tr>";
			print "<td>".$row->id_pedido."</td>";
			print "<td>".$row->nome_cardapio."</td>";
			print "<td>".$row->quantidade_pedido."</td>";
			print "<td>
					<button class='btn btn-success' onclick=\"location.href='?page=editar-pedido&id_pedido=".$row->id_pedido."';\">Editar</button>

					<button class='btn btn-danger' onclick=\"confirmDelete('?page=salvar-pedido&acao=excluir&id_pedido=".$row->id_pedido."')\">Excluir</button>
				   </td>";
			print "</tr>";
		}
		print "</table>";

	}else{
		print "Nenhum resultado";
	}
?>