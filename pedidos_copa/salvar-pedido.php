<?php
	switch ($_REQUEST['acao']) {
		case 'cadastrar':

			$cardapio_id = isset($_POST['cardapio_id_cardapio']) ? $_POST['cardapio_id_cardapio'] : '';
			$quantidade  = isset($_POST['quantidade_pedido']) ? $_POST['quantidade_pedido'] : '';

			if ($cardapio_id == '' || $cardapio_id == '-=Escolha=-') {
				print "<script>alert('Erro: Por favor, selecione um item válido do cardápio!');</script>";
				print "<script>history.back();</script>";
				break;
			}

			$sql = "INSERT INTO pedido (
						cardapio_id_cardapio, 
						quantidade_pedido
					) VALUES (
						'{$cardapio_id}',
						'{$quantidade}'
					)";

			$res = $conn->query($sql);

			if($res == true){
				print "<script>alert('Cadastrou com sucesso!');</script>";
				print "<script>location.href='?page=listar-pedido';</script>";
			}else{
				print "<script>alert('Não cadastrou');</script>";
				print "<script>location.href='?page=listar-pedido';</script>";
			}

			break;

		case 'editar':
				$nome       = isset($_POST['nome_pedido']) ? $_POST['nome_pedido'] : '';
				$quantidade = isset($_POST['quantidade_pedido']) ? $_POST['quantidade_pedido'] : '';

				if (empty($nome) || empty($quantidade)) {
					print "<script>alert('Erro: O nome do item e a quantidade não podem ficar vazios!');</script>";
					print "<script>history.back();</script>"; 
					break; 
				}	

				$sql = "UPDATE pedido SET 
							nome_pedido='{$nome}',
							quantidade_pedido='{$quantidade}'
						WHERE
							id_pedido=".$_POST["id_pedido"];

				$res = $conn->query($sql);

				if($res == true){
					print "<script>alert('Editou com sucesso!');</script>";
					print "<script>location.href='?page=listar-pedido';</script>";
				}else{
					print "<script>alert('Não editou');</script>";
					print "<script>location.href='?page=listar-pedido';</script>";
				}
				break;

			case 'excluir':
				$sql = "DELETE FROM pedido WHERE id_pedido=".$_REQUEST["id_pedido"];

				$res = $conn->query($sql);

				if($res == true){
					print "<script>alert('Excluiu com sucesso!');</script>";
					print "<script>location.href='?page=listar-pedido';</script>";
				}else{
					print "<script>alert('Não excluiu');</script>";
					print "<script>location.href='?page=listar-pedido';</script>";
				}
				break;
		}