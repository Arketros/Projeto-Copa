<?php
$current_page = @$_REQUEST['page'];

// Verifica se há pedidos na fila (pendentes hoje)
$hoje = date('Y-m-d');
$sql_pend = "SELECT COUNT(id_solicitacao) as total FROM solicitacao WHERE status = 'Pendente' AND data_hora LIKE '{$hoje}%'";
$res_pend = $conn->query($sql_pend);
$total_pendentes = ($res_pend && $res_pend->num_rows > 0) ? $res_pend->fetch_object()->total : 0;
?>
<div class="mobile-dock">
    <a href="?page=painel-pedidos" class="dock-item <?php echo (empty($current_page) || $current_page == 'painel-pedidos') ? 'active' : ''; ?>">
        <div style="position: relative; display: inline-block;">
            <i data-lucide="list-ordered" class="dock-icon"></i>
            <?php if ($total_pendentes > 0): ?>
                <span class="badge bg-danger rounded-circle position-absolute" style="top: -5px; right: -12px; font-size: 0.65rem; padding: 3px 5px;"><?php echo $total_pendentes; ?></span>
            <?php endif; ?>
        </div>
        <span>Fila</span>
    </a>
    <a href="?page=listar-cardapio" class="dock-item <?php echo ($current_page == 'listar-cardapio' || strpos($current_page, 'cardapio') !== false) ? 'active' : ''; ?>">
        <i data-lucide="coffee" class="dock-icon"></i>
        <span>Cardápio</span>
    </a>
    <a href="?page=listar-sala" class="dock-item <?php echo ($current_page == 'listar-sala') ? 'active' : ''; ?>">
        <i data-lucide="door-open" class="dock-icon"></i>
        <span>Salas</span>
    </a>
    <a href="?acao=logout" class="dock-item text-danger">
        <i data-lucide="log-out" class="dock-icon"></i>
        <span>Sair</span>
    </a>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
