<?php


if (isset($_SESSION['usuario_nivel']) && isset($_SESSION['usuario_email'])) {
    if ($_SESSION['usuario_email'] != $_SESSION['cliente_email']) {
        unset($_SESSION['usuario_nivel']);
        unset($_SESSION['usuario_nome']);
        unset($_SESSION['usuario_id']);
        unset($_SESSION['usuario_email']);
    }
}

if (!isset($_SESSION['usuario_nivel'])) {
    include('cliente-login-painel.php');
} else {
    
    echo "<script>window.location.href='index.php?page=painel-pedidos';</script>";
}
?>
