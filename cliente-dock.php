<?php
$current_page = @$_REQUEST['page'];


$email_dock = $_SESSION['cliente_email'];
$sql_check_nivel = "SELECT nivel_usuario FROM usuario WHERE email_usuario = '{$email_dock}' AND status_usuario != 'Excluído'";
$res_nivel = $conn->query($sql_check_nivel);
$is_gestor = false;
if ($res_nivel && $res_nivel->num_rows > 0) {
    $nivel_dock = $res_nivel->fetch_object()->nivel_usuario;
    if ($nivel_dock == 'Admin' || $nivel_dock == 'Operador') {
        $is_gestor = true;
    }
}
?>
<div class="mobile-dock">
    <a href="?page=cliente-fila" class="dock-item <?php echo ($current_page == 'cliente-fila') ? 'active' : ''; ?>">
        <i data-lucide="list-ordered" class="dock-icon"></i>
        <span>Fila</span>
    </a>
    <a href="?page=cliente-meus-pedidos" class="dock-item <?php echo (empty($current_page) || $current_page == 'cliente-fazer-pedido' || $current_page == 'cliente-meus-pedidos') ? 'active' : ''; ?>">
        <i data-lucide="coffee" class="dock-icon"></i>
        <span>Pedir</span>
    </a>
    <a href="?page=cliente-historico" class="dock-item <?php echo ($current_page == 'cliente-historico') ? 'active' : ''; ?>">
        <i data-lucide="history" class="dock-icon"></i>
        <span>Histórico</span>
    </a>
    <a href="?page=cliente-perfil" class="dock-item <?php echo ($current_page == 'cliente-perfil') ? 'active' : ''; ?>">
        <i data-lucide="user" class="dock-icon"></i>
        <span>Perfil</span>
    </a>
    
    <?php if($is_gestor): ?>
    <a href="?page=cliente-painel" class="dock-item <?php echo ($current_page == 'cliente-painel') ? 'active' : ''; ?>">
        <i data-lucide="settings" class="dock-icon"></i>
        <span>Painel</span>
    </a>
    <?php endif; ?>
</div>


<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
<?php if (!isset($is_admin_flow_from_mobile)): ?>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<?php endif; ?>
