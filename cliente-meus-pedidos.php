<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meus Pedidos - Seven</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
</head>

<body>
    <div class="blue-header">
        <h4>Meus Pedidos</h4>
        <p>Gerencie seus pedidos atuais</p>
    </div>

    <div class="container mb-5 pb-5">
        <div class="custom-card floating-card">
            <?php
            if (isset($_POST['acao']) && $_POST['acao'] == 'finalizar_pedido_individual') {
                $id_s = (int) $_POST['id_solicitacao'];
                $sql_fin = "UPDATE solicitacao SET status = 'Finalizado' WHERE id_solicitacao = {$id_s} AND email_cliente = '{$_SESSION['cliente_email']}'";
                $conn->query($sql_fin);
                echo "<div class='alert alert-success'>Pedido finalizado com sucesso!</div>";
            }
            if (isset($_POST['acao']) && $_POST['acao'] == 'cancelar_pedido_individual') {
                $id_s = (int) $_POST['id_solicitacao'];
                $sql_canc = "UPDATE solicitacao SET status = 'Cancelado' WHERE id_solicitacao = {$id_s} AND email_cliente = '{$_SESSION['cliente_email']}'";
                $conn->query($sql_canc);
                echo "<div class='alert alert-warning'>Pedido cancelado com sucesso!</div>";
            }
            ?>


            <div class="d-grid gap-2 mb-4">
                <a href="?page=cliente-fazer-pedido"
                    class="btn btn-primary d-flex align-items-center justify-content-center">
                    <i data-lucide="plus-circle" class="me-2"></i> Fazer Novo Pedido
                </a>
            </div>

            <h6 class="mb-3 text-muted">Pedidos em Andamento</h6>

            <div class="menu-list">
                <?php
                $email = $_SESSION['cliente_email'];


                $hash = $_SESSION['sala_hash'];
                $sql_sala = "SELECT id_sala FROM sala WHERE hash_url = '{$hash}'";
                $res_sala = $conn->query($sql_sala);
                $id_sala = 0;
                if ($res_sala && $res_sala->num_rows > 0) {
                    $id_sala = $res_sala->fetch_object()->id_sala;
                }


                $hoje = date('Y-m-d');
                $sql = "SELECT * FROM solicitacao 
                            WHERE email_cliente = '{$email}' AND status NOT IN ('Finalizado', 'Cancelado') AND data_hora LIKE '{$hoje}%'
                            ORDER BY data_hora DESC";
                $res = $conn->query($sql);

                if ($res && $res->num_rows > 0) {
                    while ($row = $res->fetch_object()) {

                        $sql_itens = "SELECT ci.quantidade, c.nome_cardapio FROM solicitacao_item ci
                                          JOIN cardapio c ON ci.id_cardapio = c.id_cardapio
                                          WHERE ci.id_solicitacao = {$row->id_solicitacao}";
                        $res_itens = $conn->query($sql_itens);
                        $itens_str = "";
                        while ($it = $res_itens->fetch_object()) {
                            $itens_str .= "{$it->quantidade}x {$it->nome_cardapio}<br>";
                        }

                        $bg_status = 'bg-warning';
                        if ($row->status == 'Processando' || $row->status == 'Em Andamento')
                            $bg_status = 'bg-info';

                        ?>
                        <div class="p-3 mb-3 bg-light rounded border">
                            <div class="d-flex justify-content-between mb-2 align-items-center">
                                <small class="text-muted"><?php echo date('H:i', strtotime($row->data_hora)); ?></small>
                                <span class="badge <?php echo $bg_status; ?> text-dark"><?php echo $row->status; ?></span>
                            </div>
                            <div class="small mb-3">
                                <strong>Itens:</strong><br>
                                <?php echo $itens_str; ?>
                            </div>

                            <div class="d-flex gap-2">
                                <form method="POST" class="w-50">
                                    <input type="hidden" name="acao" value="finalizar_pedido_individual">
                                    <input type="hidden" name="id_solicitacao" value="<?php echo $row->id_solicitacao; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-success w-100">Já recebi</button>
                                </form>
                                <button type="button" class="btn btn-sm btn-outline-danger w-50"
                                    onclick="confirmCancelClient(<?php echo $row->id_solicitacao; ?>)">Cancelar</button>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='text-center text-muted my-4'><i data-lucide='inbox' class='mb-2' style='width: 30px; height: 30px; opacity: 0.5;'></i><br>Nenhum pedido em andamento no momento.</div>";
                }
                ?>
            </div>

            <script>
                setTimeout(function () {
                    window.location.reload();
                }, 10000);
            </script>
        </div>
    </div>

    <!-- Modal Cancelamento Cliente -->
    <div class="modal fade" id="cancelClientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-warning text-dark border-0">
                    <h5 class="modal-title">Confirmar Cancelamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4 text-center">
                    <p class="mb-0 fs-5">Tem certeza que deseja cancelar este pedido?</p>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal">Voltar</button>
                    <form id="cancelClientForm" method="POST">
                        <input type="hidden" name="acao" value="cancelar_pedido_individual">
                        <input type="hidden" name="id_solicitacao" id="cancelClientId" value="">
                        <button type="submit" class="btn btn-danger px-4 py-2">Sim, Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function confirmCancelClient(id) {
            document.getElementById('cancelClientId').value = id;
            var myModal = new bootstrap.Modal(document.getElementById('cancelClientModal'));
            myModal.show();
        }
    </script>

    <?php include('cliente-dock.php'); ?>
</body>

</html>