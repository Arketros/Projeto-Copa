<?php

$dbPath = __DIR__ . '/database.db';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conectado ao banco de dados com sucesso.<br>\n";

    $stmt = $pdo->query("SELECT COUNT(*) FROM cardapio");
    if ($stmt->fetchColumn() < 10) {
        $fake_cardapio = [
            ['Jarro de Água', 'Bebida', 'Ativo'],
            ['Pão de Queijo', 'Lanche', 'Ativo'],
            ['Café', 'Bebida', 'Ativo'],
            ['Água com Gás', 'Bebida', 'Ativo'],
            ['Suco de Laranja', 'Bebida', 'Ativo'],
        ];

        $insertCardapio = $pdo->prepare("INSERT INTO cardapio (nome_cardapio, categoria_cardapio, situacao_cardapio, total_pedidos) VALUES (?, ?, ?, 0)");
        foreach ($fake_cardapio as $item) {
            $insertCardapio->execute([$item[0], $item[1], $item[2]]);
        }
        echo "Itens de cardápio fakes inseridos com sucesso.<br>\n";
    } else {
        echo "O cardápio já possui itens suficientes.<br>\n";
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>