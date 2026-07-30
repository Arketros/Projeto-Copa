<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bem-vindo à Copa - Seven</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <div class="custom-card login-card text-center">
        <?php
            
            $nome_sala = "Sala Desconhecida";
            $hash = $_SESSION['sala_hash'];
            $sql = "SELECT nome_sala FROM sala WHERE hash_url = '{$hash}'";
            $res = $conn->query($sql);
            if ($res && $res->num_rows > 0) {
                $nome_sala = $res->fetch_object()->nome_sala;
            } else {
                echo "<div class='alert alert-danger'>QR Code inválido ou sala não encontrada.</div>";
                exit;
            }
        ?>
        <div id="identificacao-form" style="display: none;">
            <h3 class="mb-2">Bem-vindo à Copa Seven</h3>
            <p class="text-muted mb-4">Você está na <strong><?php echo $nome_sala; ?></strong></p>

            <form id="client-login-form" action="index.php?sala=<?php echo $hash; ?>" method="POST">
                <input type="hidden" name="acao" value="identificar_cliente">
                <div class="mb-4 text-start">
                    <label>Identifique-se com seu E-mail</label>
                    <input type="email" id="email-input" name="email" class="form-control" placeholder="seu@email.com" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Acessar Cardápio</button>
            </form>
        </div>
        
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let savedClient = localStorage.getItem('cliente_email');
                if (savedClient) {
                    document.getElementById('email-input').value = savedClient;
                    document.getElementById('client-login-form').submit();
                } else {
                    document.getElementById('identificacao-form').style.display = 'block';
                }
            });
        </script>
    </div>

    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    
    <?php if(isset($_SESSION['toast_msg'])): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
        <div id="liveToast" class="toast align-items-center text-bg-<?php echo $_SESSION['toast_type']; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $_SESSION['toast_msg']; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastEl = document.getElementById('liveToast');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    </script>
    <?php 
        unset($_SESSION['toast_msg']); 
        unset($_SESSION['toast_type']);
    endif; ?>
</body>
</html>
