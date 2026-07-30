<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Meu Perfil - Seven</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
    <div class="blue-header">
        <div style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); border: 2px solid white; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 10px;">
            <i data-lucide="user" style="width: 40px; height: 40px;"></i>
        </div>
        <h4>Meu Perfil</h4>
        <p><?php echo $_SESSION['cliente_email']; ?></p>
        
        <?php
            $email = $_SESSION['cliente_email'];
            $sql_user = "SELECT prioridade_atendimento FROM usuario WHERE email_usuario = '{$email}'";
            $res_user = $conn->query($sql_user);
            if ($res_user && $res_user->num_rows > 0) {
                $prio = $res_user->fetch_object()->prioridade_atendimento;
                
                
                $stars_count = max(1, $prio); 
                
                echo "<div class='mt-2' style='color: #FFD700;'>"; 
                for($i=0; $i<$stars_count; $i++) {
                    echo "<i data-lucide='star' fill='#FFD700' style='width:20px; height:20px;'></i>";
                }
                echo "</div>";
            } else {
                echo "<span class='badge bg-light text-dark mt-2'>Convidado</span>";
            }
        ?>
    </div>

    <div class="container mb-5 pb-5">
        <div class="custom-card floating-card text-center">
            <h5 class="mb-4">Configurações</h5>
            <div class="d-grid gap-2">
                <a href="?acao=sair_cliente&sala=<?php echo $_SESSION['sala_hash']; ?>" class="btn btn-outline-danger">Sair / Trocar Usuário</a>
            </div>
        </div>
    </div>
    
    <?php include('cliente-dock.php'); ?>
</body>
</html>
