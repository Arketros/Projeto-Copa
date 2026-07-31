<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Meu Histórico - Seven</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
    <div class="blue-header">
        <h4>Meu Histórico</h4>
        <p>Pedidos antigos feitos por você</p>
    </div>

    <div class="container mb-5 pb-5">
        <div class="custom-card floating-card">

            <div class="menu-list">
                <?php
                    $email = $_SESSION['cliente_email'];

                    $sql = "SELECT s.*, sa.nome_sala FROM solicitacao s
                            LEFT JOIN sala sa ON s.id_sala = sa.id_sala
                            WHERE s.email_cliente = '{$email}' AND s.status = 'Finalizado' 
                            ORDER BY s.data_hora DESC LIMIT 50";
                    $res = $conn->query($sql);
                    $modals_html = "";
                    
                    if ($res && $res->num_rows > 0) {
                        while($row = $res->fetch_object()){
                            
                            $sql_itens = "SELECT ci.quantidade, c.nome_cardapio FROM solicitacao_item ci
                                          JOIN cardapio c ON ci.id_cardapio = c.id_cardapio
                                          WHERE ci.id_solicitacao = {$row->id_solicitacao}";
                            $res_itens = $conn->query($sql_itens);
                            $itens_preview = "";
                            $itens_comanda = "";
                            while($it = $res_itens->fetch_object()){
                                $itens_preview .= "{$it->quantidade}x {$it->nome_cardapio}<br>";
                                $itens_comanda .= "<div class='comanda-row'><span>{$it->quantidade}x {$it->nome_cardapio}</span></div>";
                            }

                            ?>
                            <div class="p-3 mb-3 bg-light rounded border shadow-sm" onclick="openHistoryModal(<?php echo $row->id_solicitacao; ?>)" style="cursor:pointer; transition: 0.2s;">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted fw-bold"><?php echo date('d/m/Y H:i', strtotime($row->data_hora)); ?></small>
                                    <span class="badge bg-success">Finalizado</span>
                                </div>
                                <div class="small fw-bold mb-2 text-primary d-flex align-items-center">
                                    <i data-lucide="map-pin" style="width:14px; height:14px;" class="me-1"></i> <?php echo $row->nome_sala; ?>
                                </div>
                                <div class="small text-muted">
                                    <?php echo $itens_preview; ?>
                                </div>
                            </div>
                            
                            <!-- Modal for this item -->
                            <?php ob_start(); ?>
                            <div class="modal fade" id="historyModal<?php echo $row->id_solicitacao; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 bg-transparent">
                                        <div class="modal-body p-0">
                                            <div class="comanda-receipt text-start position-relative" style="margin: 0 auto; max-width: 100%;">
                                                <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" style="top: 15px; right: 15px; z-index: 10;"></button>
                                                <div class="comanda-header pe-4">
                                                    <h4>Mesa: <?php echo $row->nome_sala; ?></h4>
                                                    <div class="small mt-1">Data: <?php echo date('d/m/Y H:i', strtotime($row->data_hora)); ?></div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="comanda-row fw-bold"><span>Reunião:</span> <span><?php echo $row->tipo_encontro; ?></span></div>
                                                    <div class="comanda-row fw-bold"><span>Pessoas:</span> <span><?php echo ($row->quantidade_pessoas == 0) ? 'Não informada' : $row->quantidade_pessoas . ' pes.'; ?></span></div>
                                                </div>
                                                <div class="comanda-divider"></div>
                                                <div class="mb-2 fw-bold text-center">ITENS SOLICITADOS</div>
                                                <?php echo $itens_comanda; ?>
                                                <div class="comanda-divider"></div>
                                                <div class="text-center small mt-3">Pedido #<?php echo $row->id_solicitacao; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $modals_html .= ob_get_clean(); ?>
                            <?php
                        }
                    } else {
                        echo "<div class='alert alert-secondary'>Você ainda não possui pedidos finalizados.</div>";
                    }
                ?>
            </div>
            
            <script>
            function openHistoryModal(id) {
                var myModal = new bootstrap.Modal(document.getElementById('historyModal' + id));
                myModal.show();
            }
            </script>
        </div>
    </div>
    
    <?php echo isset($modals_html) ? $modals_html : ''; ?>
    <?php include('cliente-dock.php'); ?>
</body>
</html>
