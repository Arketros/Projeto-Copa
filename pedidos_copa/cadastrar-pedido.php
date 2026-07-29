<h1>Fazer Pedido</h1>
<form action="?page=salvar-pedido" method="POST">
	<input type="hidden" name="acao" value="cadastrar">
	
	<div class="mb-3">
		<label>Cardápio</label>
		<select name="cardapio_id_cardapio" class="form-control">
			<option>-=Escolha=-</option>
			<?php
				$sql = "SELECT * FROM cardapio";
				$res = $conn->query($sql);
				$qtd = $res->num_rows;
				if($qtd > 0){
					while($row = $res->fetch_object()){
	                    $disabled = ($row->situacao_cardapio == 'Indisponível') ? 'disabled' : '';
	                    $texto_opcao = $row->nome_cardapio;
	                    if ($row->situacao_cardapio == 'Indisponível') {
	                        $texto_opcao .= " (Indisponível)";
	                    }

	                    print "<option value='{$row->id_cardapio}' {$disabled}>
	                            {$texto_opcao}
									</option>";
					}
				}else{
					print "<option>Nenhum cardapio</option>";
				}
			?>
		</select>
	</div>



	<div class="row align-items-end mb-3">
		<div class="col-auto" style="width: 160px;">
			<label class="form-label">Quantidade</label>
			<div class="input-group">
				<button class="btn btn-outline-secondary" type="button" onclick="alterarQuantidade(-1)">-</button>
				<input type="number" name="quantidade_pedido" id="quantidade_pedido" class="form-control text-center" value="1" min="1">
				<button class="btn btn-outline-secondary" type="button" onclick="alterarQuantidade(1)">+</button>
			</div>
		</div>
		
		<div class="col-auto">
			<button type="submit" class="btn btn-primary">Enviar</button>
		</div>
	</div>

	<script>
	function alterarQuantidade(valor) {
		var input = document.getElementById('quantidade_pedido');
		var valorAtual = parseInt(input.value) || 0;
		var novoValor = valorAtual + valor;
		
		if (novoValor >= 1) {
			input.value = novoValor;
		}
	}
	</script>
</form>