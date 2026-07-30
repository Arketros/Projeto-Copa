<?php
	switch ($_REQUEST['acao']) {
		case 'cadastrar':
			$nome 	= $_POST['nome_usuario'];
			$email 	= $_POST['email_usuario'];
			$senha 	= $_POST['senha_usuario'];
			$nivel  = $_POST['nivel_usuario'];
			$prioridade = (int)$_POST["prioridade_atendimento"];

			$sql = "INSERT INTO usuario (
						nome_usuario,
						email_usuario,
						senha_usuario,
						nivel_usuario,
						prioridade_atendimento
					) VALUES (
						'{$nome}',
						'{$email}',
						'{$senha}',
						'{$nivel}',
						{$prioridade}
					)";

			$res = $conn->query($sql);

			if($res == true){
				$_SESSION['toast_msg'] = 'Cadastrou com sucesso!'; $_SESSION['toast_type'] = (strpos('Cadastrou com sucesso!', 'Não') === false && strpos('Cadastrou com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-usuario'); exit;
			}else{
				$_SESSION['toast_msg'] = 'Não cadastrou'; $_SESSION['toast_type'] = (strpos('Não cadastrou', 'Não') === false && strpos('Não cadastrou', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-usuario'); exit;
			}
									

			break;
		
		case 'editar':
			$nome 	= $_POST['nome_usuario'];
			$email 	= $_POST['email_usuario'];
			$senha 	= $_POST['senha_usuario'];
			$nivel  = $_POST['nivel_usuario'];
			$prioridade = (int)$_POST["prioridade_atendimento"];

			$sql = "UPDATE usuario SET  
						nome_usuario='{$nome}',
						email_usuario='{$email}',
						senha_usuario='{$senha}',
						nivel_usuario='{$nivel}',
						prioridade_atendimento={$prioridade}
					WHERE
						id_usuario=".$_POST["id_usuario"];

			$res = $conn->query($sql);

			if($res == true){
				$_SESSION['toast_msg'] = 'Editou com sucesso!'; $_SESSION['toast_type'] = (strpos('Editou com sucesso!', 'Não') === false && strpos('Editou com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-usuario'); exit;
			}else{
				$_SESSION['toast_msg'] = 'Não editou'; $_SESSION['toast_type'] = (strpos('Não editou', 'Não') === false && strpos('Não editou', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-usuario'); exit;
			}
			break;

		case 'excluir':
			$sql = "UPDATE usuario SET status_usuario='Excluído' WHERE id_usuario=".$_GET["id_usuario"];

			$res = $conn->query($sql);

			if($res == true){
				$_SESSION['toast_msg'] = 'Excluiu com sucesso!'; $_SESSION['toast_type'] = (strpos('Excluiu com sucesso!', 'Não') === false && strpos('Excluiu com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-usuario'); exit;
			}else{
				$_SESSION['toast_msg'] = 'Não excluiu'; $_SESSION['toast_type'] = (strpos('Não excluiu', 'Não') === false && strpos('Não excluiu', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-usuario'); exit;
			}
			break;
	}