<?php

$dbPath = __DIR__ . '/database.db';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conectado ao banco de dados com sucesso.<br>\n";

    $stmt = $pdo->query("SELECT COUNT(*) FROM cardapio");
    if ($stmt->fetchColumn() < 10) {
        $fake_cardapio = [
            ['Café Expresso', 'Ativo'],
            ['Café com Leite', 'Ativo'],
            ['Chá de Camomila', 'Ativo'],
            ['Água com Gás', 'Ativo'],
            ['Suco de Laranja', 'Ativo'],
            ['Pão de Queijo', 'Ativo'],
            ['Biscoito Amanteigado', 'Ativo'],
            ['Misto Quente', 'Ativo'],
            ['Bolo de Cenoura', 'Ativo'],
            ['Croissant', 'Ativo'],
        ];
        
        $insertCardapio = $pdo->prepare("INSERT INTO cardapio (nome_cardapio, situacao_cardapio, total_pedidos) VALUES (?, ?, 0)");
        foreach ($fake_cardapio as $item) {
            $insertCardapio->execute([$item[0], $item[1]]);
        }
        echo "Itens de cardápio fakes inseridos com sucesso.<br>\n";
    } else {
        echo "O cardápio já possui itens suficientes.<br>\n";
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
