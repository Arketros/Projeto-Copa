<h1>Histórico de Pedidos</h1>
<?php
	
	$sql = "SELECT s.*, sa.nome_sala 
            FROM solicitacao s 
            JOIN sala sa ON s.id_sala = sa.id_sala 
            ORDER BY s.data_hora DESC 
            LIMIT 100"; 
	$res = $conn->query($sql);
	$qtd = $res->num_rows;

	if($qtd > 0){
		print "<div class='table-responsive'><table class='table custom-table'>";
		print "<tr>";
		print "<th>ID</th>";
		print "<th>Sala</th>";
		print "<th>Cliente (E-mail)</th>";
		print "<th>Reunião</th>";
		print "<th>Itens</th>";
		print "<th>Status</th>";
		print "</tr>";
		while($row = $res->fetch_object()){
            
            
            $sql_itens = "SELECT ci.quantidade, c.nome_cardapio FROM solicitacao_item ci
                          JOIN cardapio c ON ci.id_cardapio = c.id_cardapio
                          WHERE ci.id_solicitacao = {$row->id_solicitacao}";
            $res_itens = $conn->query($sql_itens);
            $itens_str = "";
            while($it = $res_itens->fetch_object()){
                $itens_str .= "{$it->quantidade}x {$it->nome_cardapio}<br>";
            }

			$data_br = date('d/m/Y H:i', strtotime($row->data_hora));
			
			$badge_class = 'bg-success';
			if ($row->status == 'Pendente') $badge_class = 'bg-warning text-dark';
			if ($row->status == 'Processando') $badge_class = 'bg-info text-dark';

			print "<tr>";
			print "<td>".$row->id_solicitacao."</td>";
			print "<td>".$row->nome_sala."</td>";
			print "<td>".$row->email_cliente."</td>";
			$pessoas_str = ($row->quantidade_pessoas == 0) ? "Pessoas: Não informada" : $row->quantidade_pessoas . " pes.";
			print "<td>".$row->tipo_encontro." (".$pessoas_str.")</td>";
			print "<td>".$itens_str."</td>";
			print "<td><span class='badge {$badge_class}'>".$row->status."</span><br><small>".$data_br."</small></td>";
			print "</tr>";
		}
		print "</table></div>";
	}else{
		print "<p class='alert alert-warning mt-4'>Nenhum pedido finalizado no momento.</p>";
	}
?>
