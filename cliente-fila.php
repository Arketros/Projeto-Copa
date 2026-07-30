<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fila de Pedidos - Seven</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <style>
        .queue-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .status-Pendente {
            background-color: #ffc107;
            color: #000;
        }

        .status-Processando {
            background-color: #0dcaf0;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="blue-header">
        <h4>Fila Geral</h4>
        <p>Acompanhe todos os pedidos</p>
    </div>

    <div class="container mb-5 pb-5">
        <div class="custom-card floating-card">

            <div class="menu-list mb-4">
                <?php

                $meu_email = isset($_SESSION['cliente_email']) ? $_SESSION['cliente_email'] : '';


                $hoje = date('Y-m-d');
                $sql = "SELECT s.*, sa.nome_sala 
                            FROM solicitacao s 
                            JOIN sala sa ON s.id_sala = sa.id_sala 
                            WHERE s.status != 'Finalizado' AND s.data_hora LIKE '{$hoje}%'
                            ORDER BY s.prioridade_calculada ASC, s.data_hora ASC";
                $res = $conn->query($sql);

                if ($res && $res->num_rows > 0) {
                    $posicao = 1;
                    while ($row = $res->fetch_object()) {
                        $bg_status = $row->status == 'Pendente' ? 'bg-warning text-dark' : 'bg-info text-dark';


                        $is_mine = ($row->email_cliente === $meu_email);
                        $border_class = $is_mine ? 'border-primary border-2 bg-light' : '';
                        $badge_mine = $is_mine ? '<span class="badge bg-primary ms-2">Seu Pedido</span>' : '';

                        ?>
                        <div class="queue-item flex-column align-items-start rounded <?php echo $border_class; ?>">
                            <div class="w-100 d-flex justify-content-between mb-2">
                                <strong>
                                    <span class="badge bg-secondary me-2">#<?php echo $posicao; ?></span>
                                    <?php echo $row->nome_sala; ?>         <?php echo $badge_mine; ?>
                                </strong>
                                <span class="badge <?php echo $bg_status; ?>"><?php echo $row->status; ?></span>
                            </div>
                            <div class="text-muted small mb-1">
                                <i data-lucide="users" style="width: 14px; height: 14px;"></i>
                                <?php echo $row->quantidade_pessoas; ?> pessoa(s)
                            </div>
                        </div>
                        <?php
                        $posicao++;
                    }
                } else {
                    echo "<div class='alert alert-success'>Nenhum pedido em aberto no momento!</div>";
                }
                ?>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function () {
            window.location.reload();
        }, 10000);
    </script>

    <?php include('cliente-dock.php'); ?>
</body>

</html>