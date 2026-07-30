<?php
session_start();
include('config.php');

if (!isset($_SESSION['cliente_email']) || !isset($_POST['id_sala'])) {
    header("Location: index.php");
    exit;
}

$id_sala = (int)$_POST['id_sala'];
$email = $_SESSION['cliente_email'];
$tipo_encontro = !empty($_POST['tipo_encontro']) ? $_POST['tipo_encontro'] : 'Normal';
$qtd_pessoas = (isset($_POST['quantidade_pessoas']) && $_POST['quantidade_pessoas'] !== '') ? (int)$_POST['quantidade_pessoas'] : 0;
$itens = $_POST['itens']; 


$prioridade_usuario = 3; 
$sql_user = "SELECT prioridade_atendimento FROM usuario WHERE email_usuario = '{$email}'";
$res_user = $conn->query($sql_user);
if ($res_user && $res_user->num_rows > 0) {
    $prioridade_usuario = $res_user->fetch_object()->prioridade_atendimento;
}








$prioridade_calculada = $prioridade_usuario;
if ($tipo_encontro == 'AGM') {
    $prioridade_calculada = 100; 
} else if ($tipo_encontro == 'Executiva') {
    $prioridade_calculada = 50;
}


$total_itens = 0;
if (is_array($itens)) {
    foreach ($itens as $qtd) {
        $total_itens += (int)$qtd;
    }
}
if ($total_itens == 0) {
    $_SESSION['toast_msg'] = 'Você deve selecionar pelo menos um item do cardápio.'; $_SESSION['toast_type'] = 'danger'; header('Location: ' . $_SERVER['HTTP_REFERER']); exit;
    exit;
}


$agora = date('Y-m-d H:i:s');
$sql_insert = "INSERT INTO solicitacao (id_sala, email_cliente, tipo_encontro, quantidade_pessoas, status, prioridade_calculada, data_hora) 
               VALUES ({$id_sala}, '{$email}', '{$tipo_encontro}', {$qtd_pessoas}, 'Pendente', {$prioridade_calculada}, '{$agora}')";

if ($conn->query($sql_insert)) {
    
    $res_id = $conn->query("SELECT last_insert_rowid() as id");
    $id_solicitacao = $res_id->fetch_object()->id;
    
    $_SESSION['id_solicitacao_atual'] = $id_solicitacao;

    
    foreach ($itens as $id_cardapio => $quantidade) {
        if ($quantidade > 0) {
            $id_c = (int)$id_cardapio;
            $qtd_c = (int)$quantidade; 
            
            
            $sql_item = "INSERT INTO solicitacao_item (id_solicitacao, id_cardapio, quantidade) VALUES ({$id_solicitacao}, {$id_c}, {$qtd_c})";
            $conn->query($sql_item);

            
            $sql_update_cardapio = "UPDATE cardapio SET 
                                    total_pedidos = total_pedidos + 1 
                                    WHERE id_cardapio = {$id_c}";
            $conn->query($sql_update_cardapio);
        }
    }

    
    $_SESSION['toast_msg'] = 'Pedido realizado com sucesso!'; $_SESSION['toast_type'] = 'success'; header('Location: index.php?page=cliente-meus-pedidos'); exit;
} else {
    $_SESSION['toast_msg'] = 'Erro ao processar pedido.'; $_SESSION['toast_type'] = 'danger'; header('Location: ' . $_SERVER['HTTP_REFERER']); exit;
}
?>
