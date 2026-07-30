<?php
$current_page = @$_REQUEST['page'];
?>
<div class="mobile-dock">
    <a href="?page=painel-pedidos" class="dock-item <?php echo (empty($current_page) || $current_page == 'painel-pedidos') ? 'active' : ''; ?>">
        <i data-lucide="list-ordered" class="dock-icon"></i>
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
