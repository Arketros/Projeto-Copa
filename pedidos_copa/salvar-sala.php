<?php
	switch ($_REQUEST['acao']) {
		case 'cadastrar':
			$nome = $_POST['nome_sala'];
            $capacidade = (int)$_POST["capacidade"];
            $hash = md5(uniqid(rand(), true)); 

			if (empty(trim($nome))) {
				$_SESSION['toast_msg'] = 'Erro: O nome não pode ficar vazio!'; $_SESSION['toast_type'] = 'danger'; header('Location: ' . $_SERVER['HTTP_REFERER']); 
				break; 
			}

			$sql = "INSERT INTO sala (nome_sala, hash_url, capacidade) VALUES ('{$nome}', '{$hash}', {$capacidade})";

			$res = $conn->query($sql);

			if($res==true){
				$_SESSION['toast_msg'] = 'Cadastrado com sucesso!'; $_SESSION['toast_type'] = (strpos('Cadastrado com sucesso!', 'Não') === false && strpos('Cadastrado com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-sala'); exit;
			}else{
				$_SESSION['toast_msg'] = 'Não foi possível cadastrar'; $_SESSION['toast_type'] = (strpos('Não foi possível cadastrar', 'Não') === false && strpos('Não foi possível cadastrar', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-sala'); exit;
			}
			break;
		
		case 'editar':
			$nome = $_POST['nome_sala'];
            $capacidade = (int)$_POST["capacidade"];

			if (empty(trim($nome))) {
				$_SESSION['toast_msg'] = 'Erro: O nome não pode ficar vazio!'; $_SESSION['toast_type'] = 'danger'; header('Location: ' . $_SERVER['HTTP_REFERER']); 
				break; 
			}

			$sql = "UPDATE sala SET nome_sala='{$nome}', capacidade={$capacidade} WHERE id_sala=".$_POST["id_sala"];

			$res = $conn->query($sql);

			if($res==true){
				$_SESSION['toast_msg'] = 'Editado com sucesso!'; $_SESSION['toast_type'] = (strpos('Editado com sucesso!', 'Não') === false && strpos('Editado com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-sala'); exit;
			}else{
				$_SESSION['toast_msg'] = 'Não foi possível editar'; $_SESSION['toast_type'] = (strpos('Não foi possível editar', 'Não') === false && strpos('Não foi possível editar', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-sala'); exit;
			}
			break;

		case 'excluir':
			$sql = "DELETE FROM sala WHERE id_sala=".$_REQUEST["id_sala"];

			$res = $conn->query($sql);

			if($res==true){
				$_SESSION['toast_msg'] = 'Excluído com sucesso!'; $_SESSION['toast_type'] = (strpos('Excluído com sucesso!', 'Não') === false && strpos('Excluído com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-sala'); exit;
			}else{
				$_SESSION['toast_msg'] = 'Não foi possível excluir'; $_SESSION['toast_type'] = (strpos('Não foi possível excluir', 'Não') === false && strpos('Não foi possível excluir', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-sala'); exit;
			}
			break;
	}
?>
