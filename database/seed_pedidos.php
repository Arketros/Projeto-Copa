<?php

$dbPath = __DIR__ . '/database.db';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conectado ao banco de dados com sucesso.<br>\n";

    $salas = $pdo->query("SELECT id_sala FROM sala")->fetchAll(PDO::FETCH_COLUMN);
    $usuarios = $pdo->query("SELECT email_usuario FROM usuario")->fetchAll(PDO::FETCH_COLUMN);
    $cardapios = $pdo->query("SELECT id_cardapio FROM cardapio")->fetchAll(PDO::FETCH_COLUMN);

    if (empty($salas) || empty($usuarios) || empty($cardapios)) {
        die("Erro: É necessário ter pelo menos uma sala, um usuário e um item no cardápio para gerar pedidos fakes.");
    }

    $tipos = ['Normal', 'Executiva', 'AGM'];
    $status_list = ['Pendente', 'Pendente', 'Pendente', 'Em Andamento', 'Finalizado']; 
    
    $insertSolicitacao = $pdo->prepare("INSERT INTO solicitacao (id_sala, email_cliente, tipo_encontro, quantidade_pessoas, status, prioridade_calculada, data_hora) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertItem = $pdo->prepare("INSERT INTO solicitacao_item (id_solicitacao, id_cardapio, quantidade) VALUES (?, ?, ?)");
    $updateCardapio = $pdo->prepare("UPDATE cardapio SET total_pedidos = total_pedidos + ? WHERE id_cardapio = ?");

    for ($i = 0; $i < 15; $i++) {
        $id_sala = $salas[array_rand($salas)];
        $email = $usuarios[array_rand($usuarios)];
        $tipo = $tipos[array_rand($tipos)];
        $qtd_pessoas = rand(0, 10);
        $status = $status_list[array_rand($status_list)];
        
        $prioridade = ($tipo == 'AGM') ? 0 : (($tipo == 'Executiva') ? 1 : rand(1, 3));
        
        $dias_atras = rand(0, 2);
        $minutos_atras = rand(0, 1440);
        $data_hora = date('Y-m-d H:i:s', strtotime("-$dias_atras days -$minutos_atras minutes"));

        $insertSolicitacao->execute([$id_sala, $email, $tipo, $qtd_pessoas, $status, $prioridade, $data_hora]);
        $id_solicitacao = $pdo->lastInsertId();

        $num_itens = rand(1, 3);
        $itens_adicionados = [];
        
        for ($j = 0; $j < $num_itens; $j++) {
            $id_cardapio = $cardapios[array_rand($cardapios)];
            
            if (in_array($id_cardapio, $itens_adicionados)) continue;
            
            $qtd_item = rand(1, 4);
            $insertItem->execute([$id_solicitacao, $id_cardapio, $qtd_item]);
            $updateCardapio->execute([$qtd_item, $id_cardapio]);
            
            $itens_adicionados[] = $id_cardapio;
        }
    }
    
    echo "15 pedidos fakes foram gerados com sucesso!<br>\n";
    echo "Acesse a Fila de Pedidos para visualizar os novos dados.";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
