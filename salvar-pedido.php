<?php
	switch ($_REQUEST['acao']) {
		case 'cadastrar':

			$cardapio_id = isset($_POST['cardapio_id_cardapio']) ? $_POST['cardapio_id_cardapio'] : '';
			$quantidade  = isset($_POST['quantidade_pedido']) ? $_POST['quantidade_pedido'] : '';

			if ($cardapio_id == '' || $cardapio_id == '-=Escolha=-') {
				$_SESSION['toast_msg'] = 'Erro: Por favor, selecione um item válido do cardápio!'; $_SESSION['toast_type'] = 'danger'; header('Location: ' . $_SERVER['HTTP_REFERER']); exit;
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
				$_SESSION['toast_msg'] = 'Cadastrou com sucesso!'; $_SESSION['toast_type'] = (strpos('Cadastrou com sucesso!', 'Não') === false && strpos('Cadastrou com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-pedido'); exit;
			}else{
				$_SESSION['toast_msg'] = 'Não cadastrou'; $_SESSION['toast_type'] = (strpos('Não cadastrou', 'Não') === false && strpos('Não cadastrou', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-pedido'); exit;
			}

			break;

		case 'editar':
				$nome       = isset($_POST['nome_pedido']) ? $_POST['nome_pedido'] : '';
				$quantidade = isset($_POST['quantidade_pedido']) ? $_POST['quantidade_pedido'] : '';

				if (empty($nome) || empty($quantidade)) {
					$_SESSION['toast_msg'] = 'Erro: O nome do item e a quantidade não podem ficar vazios!'; $_SESSION['toast_type'] = 'danger'; header('Location: ' . $_SERVER['HTTP_REFERER']); exit; 
					break; 
				}	

				$sql = "UPDATE pedido SET 
							nome_pedido='{$nome}',
							quantidade_pedido='{$quantidade}'
						WHERE
							id_pedido=".$_POST["id_pedido"];

				$res = $conn->query($sql);

				if($res == true){
					$_SESSION['toast_msg'] = 'Editou com sucesso!'; $_SESSION['toast_type'] = (strpos('Editou com sucesso!', 'Não') === false && strpos('Editou com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-pedido'); exit;
				}else{
					$_SESSION['toast_msg'] = 'Não editou'; $_SESSION['toast_type'] = (strpos('Não editou', 'Não') === false && strpos('Não editou', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-pedido'); exit;
				}
				break;

			case 'excluir':
				$sql = "DELETE FROM pedido WHERE id_pedido=".$_REQUEST["id_pedido"];

				$res = $conn->query($sql);

				if($res == true){
					$_SESSION['toast_msg'] = 'Excluiu com sucesso!'; $_SESSION['toast_type'] = (strpos('Excluiu com sucesso!', 'Não') === false && strpos('Excluiu com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-pedido'); exit;
				}else{
					$_SESSION['toast_msg'] = 'Não excluiu'; $_SESSION['toast_type'] = (strpos('Não excluiu', 'Não') === false && strpos('Não excluiu', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-pedido'); exit;
				}
				break;
		}