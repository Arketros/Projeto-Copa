	<?php
		switch ($_REQUEST['acao']) {
			case 'cadastrar':
				$nome     = $_POST['nome_cardapio'];
				$situacao = $_POST['situacao_cardapio'];

				if (empty(trim($nome)) || empty(trim($situacao))) {
					print "<script>alert('Erro: O nome do item e a situação/disponibilidade não podem ficar vazios!');</script>";
					print "<script>history.back();</script>"; 
					break; 
				}	

				$sql = "INSERT INTO cardapio (
							nome_cardapio,
							situacao_cardapio
						) VALUES (
							'{$nome}',
							'{$situacao}'
						)";

				$res = $conn->query($sql);

				if($res == true){
					print "<script>alert('Cadastrou com sucesso!');</script>";
					print "<script>location.href='?page=listar-cardapio';</script>";
				}else{
					print "<script>alert('Não cadastrou');</script>";
					print "<script>location.href='?page=listar-cardapio';</script>";
				}
				break;
			
			case 'editar':
				$nome     = $_POST['nome_cardapio'];
				$situacao = $_POST['situacao_cardapio'];

				if (empty(trim($nome)) || empty(trim($situacao))) {
					print "<script>alert('Erro: O nome do item e a situação/disponibilidade não podem ficar vazios!');</script>";
					print "<script>history.back();</script>"; 
					break; 
				}	

				$sql = "UPDATE cardapio SET 
							nome_cardapio='{$nome}',
							situacao_cardapio='{$situacao}'
						WHERE
							id_cardapio=".$_POST["id_cardapio"];

				$res = $conn->query($sql);

				if($res == true){
					print "<script>alert('Editou com sucesso!');</script>";
					print "<script>location.href='?page=listar-cardapio';</script>";
				}else{
					print "<script>alert('Não editou');</script>";
					print "<script>location.href='?page=listar-cardapio';</script>";
				}
				break;

			case 'excluir':
				$sql = "DELETE FROM cardapio WHERE id_cardapio=".$_REQUEST["id_cardapio"];

				$res = $conn->query($sql);

				if($res == true){
					print "<script>alert('Excluiu com sucesso!');</script>";
					print "<script>location.href='?page=listar-cardapio';</script>";
				}else{
					print "<script>alert('Não excluiu');</script>";
					print "<script>location.href='?page=listar-cardapio';</script>";
				}
				break;
		}