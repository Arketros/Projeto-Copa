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
</body>

</html>