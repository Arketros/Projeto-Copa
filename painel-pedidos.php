<h1>Fila de Pedidos</h1>
<?php

$hoje = date('Y-m-d');
$sql = "SELECT s.*, sa.nome_sala 
            FROM solicitacao s 
            JOIN sala sa ON s.id_sala = sa.id_sala 
            WHERE s.status IN ('Pendente', 'Processando', 'Em Andamento') AND s.data_hora LIKE '{$hoje}%'
            ORDER BY s.prioridade_calculada ASC, s.data_hora ASC";
$res = $conn->query($sql);
$qtd = $res->num_rows;

if ($qtd > 0) {
    print "<div class='row'>";
    while ($row = $res->fetch_object()) {


        $sql_itens = "SELECT ci.quantidade, c.nome_cardapio FROM solicitacao_item ci
                          JOIN cardapio c ON ci.id_cardapio = c.id_cardapio
                          WHERE ci.id_solicitacao = {$row->id_solicitacao}";
        $res_itens = $conn->query($sql_itens);
        $itens_str = "";
        while ($it = $res_itens->fetch_object()) {
            $itens_str .= "<div class='comanda-row'><span>{$it->quantidade}x {$it->nome_cardapio}</span></div>";
        }

        $bg_status = $row->status == 'Pendente' ? 'bg-warning text-dark' : 'bg-info text-dark';
        $btn_acao = "";
        if ($row->status == 'Pendente') {
            $btn_acao = "<button class='btn btn-info w-100 fw-bold' onclick=\"location.href='?page=acao-pedido&acao=receber&id=" . $row->id_solicitacao . "';\">Receber Pedido</button>";
        } else if ($row->status == 'Processando' || $row->status == 'Em Andamento') {
            $btn_acao = "<button class='btn btn-success w-100 fw-bold' onclick=\"location.href='?page=acao-pedido&acao=finalizar&id=" . $row->id_solicitacao . "';\">Concluir Entrega</button>";
        }

        ?>
        <div class="col-md-6 col-lg-4">
            <div class="order-card">
                <div class="order-card-header">
                    <div>
                        <span class="badge <?php echo $bg_status; ?>"><?php echo $row->status; ?></span>
                    </div>
                    <small class="text-muted fw-bold"><?php echo date('H:i', strtotime($row->data_hora)); ?></small>
                </div>
                <div class="mb-3">
                    <h5 class="order-card-title text-primary mb-1"><?php echo $row->nome_sala; ?></h5>
                    <div class="text-muted small mb-2"><?php echo $row->email_cliente; ?></div>
                    <div class="small">
                        <strong>Reunião:</strong> <?php echo $row->tipo_encontro; ?> (<?php echo $row->quantidade_pessoas; ?>
                        pes.)
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary w-100"
                        onclick="openOrderModal(<?php echo $row->id_solicitacao; ?>)">
                        Ver Detalhes do Pedido
                    </button>
                </div>
            </div>
        </div>


        <div id="sheetBackdropOrder<?php echo $row->id_solicitacao; ?>" class="sheet-backdrop"
            onclick="closeOrderModal(<?php echo $row->id_solicitacao; ?>)"></div>
        <div id="detailsModalOrder<?php echo $row->id_solicitacao; ?>" class="bottom-sheet">
            <div class="bottom-sheet-header">
                <div class="bottom-sheet-drag-handle"></div>
                <h5 class="mb-0">Pedido #<?php echo $row->id_solicitacao; ?></h5>
            </div>
            <div class="bottom-sheet-content">
                <div class="comanda-receipt mb-4 text-start" style="margin: 0 auto; max-width: 100%;">
                    <div class="comanda-header">
                        <h4>Mesa: <?php echo $row->nome_sala; ?></h4>
                        <div class="small mt-1">Hora do Pedido: <?php echo date('H:i', strtotime($row->data_hora)); ?></div>
                    </div>
                    <div class="mb-3">
                        <div class="comanda-row fw-bold"><span>Reunião:</span> <span><?php echo $row->tipo_encontro; ?></span></div>
                        <div class="comanda-row fw-bold"><span>Pessoas:</span> <span><?php echo $row->quantidade_pessoas; ?> pes.</span></div>
                    </div>
                    <div class="comanda-divider"></div>
                    <div class="mb-2 fw-bold text-center">ITENS SOLICITADOS</div>
                    <?php echo $itens_str; ?>
                    <div class="comanda-divider"></div>
                    <div class="text-center small mt-3">Solicitante: <?php echo explode('@', $row->email_cliente)[0]; ?></div>
                </div>

                <div class="d-flex flex-column gap-2 mt-2">
                    <button class="btn btn-info w-100 py-3 fw-bold text-white"
                        onclick="location.href='?page=acao-pedido&acao=receber&id=<?php echo $row->id_solicitacao; ?>';">Executar</button>
                    <button class="btn btn-success w-100 py-3 fw-bold"
                        onclick="location.href='?page=acao-pedido&acao=finalizar&id=<?php echo $row->id_solicitacao; ?>';">Finalizar
                        Direto</button>
                    <button class="btn btn-danger w-100 py-3 fw-bold"
                        onclick="confirmCancel('?page=acao-pedido&acao=cancelar&id=<?php echo $row->id_solicitacao; ?>')">Cancelar</button>
                    <button class="btn btn-outline-secondary w-100 py-3"
                        onclick="closeOrderModal(<?php echo $row->id_solicitacao; ?>)">Fechar</button>
                </div>
            </div>
        </div>
        <?php
    }
    print "</div>";
} else {
    print "<p class='alert alert-success mt-4'>Nenhum pedido na fila. Bom trabalho!</p>";
}
?>
<script>
    function openOrderModal(id) {
        document.getElementById('detailsModalOrder' + id).classList.add('open');
        document.getElementById('sheetBackdropOrder' + id).classList.add('open');
    }

    function closeOrderModal(id) {
        document.getElementById('detailsModalOrder' + id).classList.remove('open');
        document.getElementById('sheetBackdropOrder' + id).classList.remove('open');
    }

    setTimeout(function () {
        window.location.reload();
    }, 10000);
</script>