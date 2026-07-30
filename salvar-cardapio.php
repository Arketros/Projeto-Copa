	<?php
		switch ($_REQUEST['acao']) {
			case 'cadastrar':
				$nome_cardapio 		= $_POST['nome_cardapio'];
				$situacao_cardapio 	= $_POST['situacao_cardapio'];
				$categoria_cardapio = $_POST['categoria_cardapio'];
				
				$imagem_url = '';
				if (isset($_FILES['imagem_arquivo']) && $_FILES['imagem_arquivo']['error'] === UPLOAD_ERR_OK) {
					$ext = pathinfo($_FILES['imagem_arquivo']['name'], PATHINFO_EXTENSION);
					$new_name = uniqid() . '.' . $ext;
					$dest = 'uploads/' . $new_name;
					if (move_uploaded_file($_FILES['imagem_arquivo']['tmp_name'], $dest)) {
						$imagem_url = $dest;
					}
				}

				if (empty(trim($nome_cardapio)) || empty(trim($situacao_cardapio))) {
					$_SESSION['toast_msg'] = 'Erro: O nome do item e a situação/disponibilidade não podem ficar vazios!'; $_SESSION['toast_type'] = 'danger'; header('Location: ' . $_SERVER['HTTP_REFERER']); 
					break; 
				}	

				$sql = "INSERT INTO cardapio (
							nome_cardapio,
							situacao_cardapio,
                            categoria_cardapio,
                            imagem_url
						) VALUES (
							'{$nome_cardapio}',
							'{$situacao_cardapio}',
                            '{$categoria_cardapio}',
                            '{$imagem_url}'
						)";

				$res = $conn->query($sql);

				if($res == true){
					$_SESSION['toast_msg'] = 'Cadastrou com sucesso!'; $_SESSION['toast_type'] = (strpos('Cadastrou com sucesso!', 'Não') === false && strpos('Cadastrou com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-cardapio'); exit;
				}else{
					$_SESSION['toast_msg'] = 'Não cadastrou'; $_SESSION['toast_type'] = (strpos('Não cadastrou', 'Não') === false && strpos('Não cadastrou', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-cardapio'); exit;
				}
				break;
			
			case 'editar':
				$nome_cardapio 		= $_POST['nome_cardapio'];
				$situacao_cardapio 	= $_POST['situacao_cardapio'];
				$categoria_cardapio = $_POST['categoria_cardapio'];
				
				$imagem_url = $_POST['imagem_url_antiga'] ?? '';
				if (isset($_FILES['imagem_arquivo']) && $_FILES['imagem_arquivo']['error'] === UPLOAD_ERR_OK) {
					$ext = pathinfo($_FILES['imagem_arquivo']['name'], PATHINFO_EXTENSION);
					$new_name = uniqid() . '.' . $ext;
					$dest = 'uploads/' . $new_name;
					if (move_uploaded_file($_FILES['imagem_arquivo']['tmp_name'], $dest)) {
						$imagem_url = $dest;
					}
				}

				if (empty(trim($nome_cardapio)) || empty(trim($situacao_cardapio))) {
					$_SESSION['toast_msg'] = 'Erro: O nome do item e a situação/disponibilidade não podem ficar vazios!'; $_SESSION['toast_type'] = 'danger'; header('Location: ' . $_SERVER['HTTP_REFERER']); 
					break; 
				}	

				$sql = "UPDATE cardapio SET 
							nome_cardapio='{$nome_cardapio}',
							situacao_cardapio='{$situacao_cardapio}',
                            categoria_cardapio='{$categoria_cardapio}',
                            imagem_url='{$imagem_url}'
						WHERE
							id_cardapio=".$_POST["id_cardapio"];

				$res = $conn->query($sql);

				if($res == true){
					$_SESSION['toast_msg'] = 'Editou com sucesso!'; $_SESSION['toast_type'] = (strpos('Editou com sucesso!', 'Não') === false && strpos('Editou com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-cardapio'); exit;
				}else{
					$_SESSION['toast_msg'] = 'Não editou'; $_SESSION['toast_type'] = (strpos('Não editou', 'Não') === false && strpos('Não editou', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-cardapio'); exit;
				}
				break;

			case 'excluir':
				$sql = "DELETE FROM cardapio WHERE id_cardapio=".$_REQUEST["id_cardapio"];

				$res = $conn->query($sql);

				if($res == true){
					$_SESSION['toast_msg'] = 'Excluiu com sucesso!'; $_SESSION['toast_type'] = (strpos('Excluiu com sucesso!', 'Não') === false && strpos('Excluiu com sucesso!', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-cardapio'); exit;
				}else{
					$_SESSION['toast_msg'] = 'Não excluiu'; $_SESSION['toast_type'] = (strpos('Não excluiu', 'Não') === false && strpos('Não excluiu', 'Erro') === false) ? 'success' : 'danger'; header('Location: ?page=listar-cardapio'); exit;
				}
				break;
		}