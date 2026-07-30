<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="m-0">Usuários</h1>
    <button class="btn btn-primary" onclick="openUsuarioModal()">+ Cadastrar Novo</button>
</div>
<?php
	$sql = "SELECT * FROM usuario";
	$res = $conn->query($sql);
	$qtd = $res->num_rows;

	if($qtd > 0){
		print "<p>Encontrou <b>$qtd</b> resultado(s)</p>";

		print "<div class='table-responsive'><table class='table table-bordered table-striped table-hover'>";
		print "<tr>";
		print "<th>#</th>";
		print "<th>Nome do Usuario</th>";
		print "<th>E-mail</th>";
		print "<th>Senha</th>";
		print "<th>Nível</th>";
		print "<th>Prioridade</th>";
		print "<th>Ações</th>";
		print "</tr>";
		while($row = $res->fetch_object()){
			print "<tr>";
			print "<td>".$row->id_usuario."</td>";
			print "<td>".$row->nome_usuario."</td>";
			print "<td>".$row->email_usuario."</td>";
			print "<td>".$row->senha_usuario."</td>";
			print "<td>".$row->nivel_usuario."</td>";
			print "<td>".$row->prioridade_atendimento."</td>";
			print "<td>
					<button class='btn btn-success' onclick=\"location.href='?page=editar-usuario&id_usuario=".$row->id_usuario."';\">Editar</button>

					<button class='btn btn-danger' onclick=\"confirmDelete('?page=salvar-usuario&acao=excluir&id_usuario=".$row->id_usuario."')\">Excluir</button>
				   </td>";
			print "</tr>";
		}
		print "</table></div>";
	}else{
		print "<p class='alert alert-warning'>Não encontrou resultados!</p>";
	}
?>


<div id="sheetBackdropUsuario" class="sheet-backdrop" onclick="closeUsuarioModal()"></div>
<div id="detailsModalUsuario" class="bottom-sheet">
    <div class="bottom-sheet-header">
        <div class="bottom-sheet-drag-handle"></div>
        <h5 class="mb-0">Cadastrar Novo Usuário</h5>
    </div>
    <div class="bottom-sheet-content">
        <form action="?page=salvar-usuario" method="POST">
            <input type="hidden" name="acao" value="cadastrar">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome_usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email_usuario" class="form-control" required>
            </div>	
            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="text" name="senha_usuario" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Nível de Acesso</label>
                <select name="nivel_usuario" class="form-select">
                    <option value="Cliente">Cliente</option>
                    <option value="Operador">Operador</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label">Prioridade de Atendimento</label>
                <select name="prioridade_atendimento" class="form-select">
                    <option value="1">Prioridade Máxima (Nível 1)</option>
                    <option value="2">Prioridade Alta (Nível 2)</option>
                    <option value="3">Prioridade Média (Nível 3)</option>
                    <option value="4">Prioridade Baixa (Nível 4)</option>
                    <option value="5" selected>Sem Prioridade (Nível 5)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-3">Salvar Usuário</button>
            <button type="button" class="btn btn-outline-secondary w-100 py-2 mt-2" onclick="closeUsuarioModal()">Cancelar</button>
        </form>
    </div>
</div>

<script>
    function openUsuarioModal() {
        document.getElementById('detailsModalUsuario').classList.add('open');
        document.getElementById('sheetBackdropUsuario').classList.add('open');
    }

    function closeUsuarioModal() {
        document.getElementById('detailsModalUsuario').classList.remove('open');
        document.getElementById('sheetBackdropUsuario').classList.remove('open');
    }
</script>