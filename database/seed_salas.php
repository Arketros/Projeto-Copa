<?php

$dbPath = __DIR__ . '/database.db';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conectado ao banco de dados com sucesso.\n";

    $fake_salas = [
        ['Sala de Reunião 5', md5(uniqid(rand(), true)), 5],
        ['Sala de Reunião 4', md5(uniqid(rand(), true)), 5],
        ['Sala de Reunião Mezanino', md5(uniqid(rand(), true)), 4],
    ];

    $insertSala = $pdo->prepare("INSERT OR IGNORE INTO sala (nome_sala, hash_url, capacidade) VALUES (?, ?, ?)");
    foreach ($fake_salas as $s) {
        $insertSala->execute($s);
    }

    echo "Salas fakes inseridas com sucesso.\n";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>