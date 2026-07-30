<?php
    $acao = @$_REQUEST['acao'];
    $id = (int)@$_REQUEST['id'];

    if ($id > 0) {
        if ($acao == 'receber') {
            $conn->query("UPDATE solicitacao SET status='Processando' WHERE id_solicitacao={$id}");
        } else if ($acao == 'finalizar') {
            $conn->query("UPDATE solicitacao SET status='Finalizado' WHERE id_solicitacao={$id}");
        } else if ($acao == 'cancelar') {
            $conn->query("UPDATE solicitacao SET status='Cancelado' WHERE id_solicitacao={$id}");
        }
    }
    
    
    print "<script>location.href='?page=painel-pedidos';</script>";
?>
