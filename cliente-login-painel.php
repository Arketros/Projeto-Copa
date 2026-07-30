<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Acesso Restrito - Seven</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
    <div class="blue-header">
        <h4>Acesso Restrito</h4>
        <p>Painel de Gestão</p>
    </div>

    <div class="container mb-5 pb-5">
        <div class="custom-card floating-card">
            <?php
            if (isset($_POST['acao']) && $_POST['acao'] == 'login_painel_mobile') {
                $email = $_SESSION['cliente_email'];
                $senha = $_POST['senha'];
                
                $sql = "SELECT * FROM usuario WHERE email_usuario='{$email}' AND senha_usuario='{$senha}'";
                $res = $conn->query($sql);
                
                if ($res && $res->num_rows > 0) {
                    $row = $res->fetch_object();
                    $_SESSION['usuario_id'] = $row->id_usuario;
                    $_SESSION['usuario_nome'] = $row->nome_usuario;
                    $_SESSION['usuario_nivel'] = $row->nivel_usuario;
                    $_SESSION['usuario_email'] = $row->email_usuario;
                    echo "<script>window.location.href='index.php?page=painel-pedidos';</script>";
                    exit;
                } else {
                    echo "<div class='alert alert-danger'>Senha incorreta.</div>";
                }
            }
            ?>
            <div class="text-center mb-4">
                <i data-lucide="lock" style="width: 48px; height: 48px; color: #0066cc;" class="mb-2"></i>
                <h5>Área do Colaborador</h5>
                <p class="text-muted small">Por segurança, confirme sua senha para acessar as funções de colaborador.</p>
            </div>

            <form method="POST">
                <input type="hidden" name="acao" value="login_painel_mobile">
                <div class="mb-4">
                    <label class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control text-center" placeholder="Sua senha" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Desbloquear Painel</button>
            </form>
        </div>
    </div>
    
    <?php include('cliente-dock.php'); ?>
</body>
</html>
