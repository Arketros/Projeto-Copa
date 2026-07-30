<?php

$dbPath = __DIR__ . '/database.db';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conectado ao banco de dados com sucesso.\n";

    $fake_usuarios = [
        ['Admin', 'admin@seven.online', '123', 'Admin', 1],
        ['Tchezery', 'tchezery.ribeiro@seven.online', '123', 'Operador', 2],
        ['Aldo', 'aldo.ribeiro@seven.online', '123', 'Cliente', 3],
        ['Lucas', 'lucas.elio@seven.online', '123', 'Cliente', 3],
        ['Valmir', 'valmir.filho@seven.online', '123', 'Cliente', 5],
        ['Romario', 'romario.guamaraes@seven.online', '123', 'Cliente', 4],
        ['Felipe', 'felipe.antunes@seven.online', '123', 'Cliente', 4],
        ['Artur', 'artur.alencar@seven.online', '123', 'Cliente', 5],
        ['Beatriz', 'beatriz.porto@seven.online', '123', 'Cliente', 4],
        ['Erica', 'erica.ferreira@seven.online', '123', 'Cliente', 4],
    ];

    $insertUser = $pdo->prepare("INSERT OR IGNORE INTO usuario (nome_usuario, email_usuario, senha_usuario, nivel_usuario, prioridade_atendimento) VALUES (?, ?, ?, ?, ?)");
    foreach ($fake_usuarios as $u) {
        $insertUser->execute($u);
    }

    echo "Usuários fakes inseridos com sucesso.\n";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>