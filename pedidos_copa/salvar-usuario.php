<?php
	switch ($_REQUEST['acao']) {
		case 'cadastrar':
			$nome 	= $_POST['nome_usuario'];
			$email 	= $_POST['email_usuario'];
			$senha 	= $_POST['senha_usuario'];

			$sql = "INSERT INTO usuario (
						nome_usuario,
						email_usuario,
						senha_usuario		
					) VALUES (
						'{$nome}',
						'{$email}',
						'{$senha}'
					)";

			$res = $conn->query($sql);

			if($res == true){
				print "<script>alert('Cadastrou com sucesso!');</script>";
				print "<script>location.href='?page=listar-usuario';</script>";
			}else{
				print "<script>alert('Não cadastrou');</script>";
				print "<script>location.href='?page=listar-usuario';</script>";
			}
									

			break;
		
		case 'editar':
			$nome 	= $_POST['nome_usuario'];
			$email 	= $_POST['email_usuario'];
			$senha 	= $_POST['senha_usuario'];

			$sql = "UPDATE usuario SET  
						nome_usuario='{$nome}',
						email_usuario='{$email}',
						senha_usuario='{$senha}'
					WHERE
						id_usuario=".$_POST["id_usuario"];

			$res = $conn->query($sql);

			if($res == true){
				print "<script>alert('Editou com sucesso!');</script>";
				print "<script>location.href='?page=listar-usuario';</script>";
			}else{
				print "<script>alert('Não editou');</script>";
				print "<script>location.href='?page=listar-usuario';</script>";
			}
			break;

		case 'excluir':
			$sql = "DELETE FROM usuario WHERE id_usuario=".$_GET["id_usuario"];

			$res = $conn->query($sql);

			if($res == true){
				print "<script>alert('Excluiu com sucesso!');</script>";
				print "<script>location.href='?page=listar-usuario';</script>";
			}else{
				print "<script>alert('Não excluiu');</script>";
				print "<script>location.href='?page=listar-usuario';</script>";
			}
			break;
	}