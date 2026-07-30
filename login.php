<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Seven</title>
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
    <script>
        localStorage.removeItem('usuario_nome');
        localStorage.removeItem('usuario_email');
        localStorage.removeItem('usuario_nivel');
    </script>
</head>

<body>
    <div class="custom-card login-card text-center">
        <h2 class="mb-4">Acesso Administrativo</h2>
        <form action="index.php" method="POST">
            <input type="hidden" name="acao" value="login">
            <div class="mb-3 text-start">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-4 text-start">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
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