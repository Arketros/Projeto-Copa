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
                    $sala_id = (int)$_SESSION['sala_hash']; 
                    
                    
                    $hash = $_SESSION['sala_hash'];
                    $sql_sala = "SELECT id_sala FROM sala WHERE hash_url = '{$hash}'";
                    $res_sala = $conn->query($sql_sala);
                    $id_sala = 0;
                    if ($res_sala && $res_sala->num_rows > 0) {
                        $id_sala = $res_sala->fetch_object()->id_sala;
                    }

                    $sql = "SELECT * FROM solicitacao 
                            WHERE email_cliente = '{$email}' AND status = 'Finalizado' 
                            ORDER BY data_hora DESC LIMIT 50";
                    $res = $conn->query($sql);
                    
                    if ($res && $res->num_rows > 0) {
                        while($row = $res->fetch_object()){
                            
                            $sql_itens = "SELECT ci.quantidade, c.nome_cardapio FROM solicitacao_item ci
                                          JOIN cardapio c ON ci.id_cardapio = c.id_cardapio
                                          WHERE ci.id_solicitacao = {$row->id_solicitacao}";
                            $res_itens = $conn->query($sql_itens);
                            $itens_str = "";
                            while($it = $res_itens->fetch_object()){
                                $itens_str .= "{$it->nome_cardapio}<br>";
                            }

                            ?>
                            <div class="p-3 mb-3 bg-light rounded border">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($row->data_hora)); ?></small>
                                    <span class="badge bg-success">Finalizado</span>
                                </div>
                                <div class="small">
                                    <?php echo $itens_str; ?>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div class='alert alert-secondary'>Você ainda não possui pedidos finalizados.</div>";
                    }
                ?>
            </div>
        </div>
    </div>
    
    <?php include('cliente-dock.php'); ?>
</body>
</html>
