<?php
ob_start();
session_start();
include('config.php');


if (!isset($_SESSION['cliente_email']) && isset($_COOKIE['cliente_email'])) {
    $_SESSION['cliente_email'] = $_COOKIE['cliente_email'];
}


if (isset($_REQUEST['sala']) || isset($_SESSION['sala_hash'])) {
    if (isset($_REQUEST['sala'])) {
        $_SESSION['sala_hash'] = $_REQUEST['sala'];
    }
    
    
    if (@$_REQUEST['acao'] == 'sair_cliente') {
        unset($_SESSION['cliente_email']);
        setcookie('cliente_email', '', time() - 3600);
        unset($_SESSION['sala_hash']);
        header("Location: index.php");
        exit;
    }
    
    
    if (@$_POST['acao'] == 'identificar_cliente') {
        $email_informado = trim($_POST['email']);
        $sql_check = "SELECT email_usuario FROM usuario WHERE email_usuario = '{$email_informado}'";
        $res_check = $conn->query($sql_check);
        
        if ($res_check && $res_check->num_rows > 0) {
            $_SESSION['cliente_email'] = $email_informado;
            setcookie('cliente_email', $email_informado, time() + (86400 * 30)); 
            header("Location: index.php");
        } else {
            $_SESSION['toast_msg'] = 'E-mail não encontrado no sistema. Por favor, contate o administrador.'; 
            $_SESSION['toast_type'] = 'danger'; 
            header("Location: index.php?sala=" . $_SESSION['sala_hash']);
        }
        exit;
    }
    
    
    if (@$_REQUEST['acao'] == 'novo_pedido_simultaneo') {
        unset($_SESSION['id_solicitacao_atual']);
        header("Location: index.php");
        exit;
    }

    $allowed_admin_pages = ['painel-pedidos', 'historico-pedidos', 'cadastrar-usuario', 'listar-usuario', 'editar-usuario', 'salvar-usuario', 'cadastrar-cardapio', 'listar-cardapio', 'editar-cardapio', 'salvar-cardapio', 'cadastrar-sala', 'listar-sala', 'salvar-sala', 'acao-pedido'];
    $req_page = @$_REQUEST['page'];

    if (!isset($_SESSION['cliente_email'])) {
        include('cliente-identificacao.php');
        exit;
    } 
    
    if (isset($_SESSION['usuario_nivel']) && in_array($req_page, $allowed_admin_pages)) {
        
        $is_admin_flow_from_mobile = true;
    } else {
        if ($req_page == 'cliente-painel') {
             include('cliente-painel.php');
        } elseif ($req_page == 'cliente-fila') {
             include('cliente-fila.php');
        } elseif (@$_REQUEST['page'] == 'cliente-fazer-pedido') {
             include('cliente-fazer-pedido.php');
        } elseif (@$_REQUEST['page'] == 'cliente-historico') {
             include('cliente-historico.php');
        } elseif (@$_REQUEST['page'] == 'cliente-perfil') {
             include('cliente-perfil.php');
        } else {
             
             include('cliente-meus-pedidos.php');
        }
        exit; 
    }
}


if (@$_REQUEST['acao'] == 'login') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $sql = "SELECT * FROM usuario WHERE email_usuario='{$email}' AND senha_usuario='{$senha}'";
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_object();
        $_SESSION['usuario_id'] = $row->id_usuario;
        $_SESSION['usuario_nome'] = $row->nome_usuario;
        $_SESSION['usuario_nivel'] = $row->nivel_usuario;
        $_SESSION['usuario_email'] = $row->email_usuario;
        header("Location: index.php");
    } else {
        $_SESSION['toast_msg'] = 'Login incorreto'; $_SESSION['toast_type'] = 'danger'; header('Location: index.php'); exit;
    }
    exit;
}

if (@$_REQUEST['acao'] == 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['usuario_nivel'])) {
    include('login.php');
    exit;
}

$page = @$_REQUEST["page"];

$is_admin = ($_SESSION['usuario_nivel'] == 'Admin');
$admin_only_pages = ['historico-pedidos', 'listar-usuario', 'cadastrar-usuario', 'editar-usuario', 'salvar-usuario', 'cadastrar-sala', 'editar-sala', 'salvar-sala'];

if (!$is_admin && in_array($page, $admin_only_pages)) {
    $_SESSION['toast_msg'] = 'Acesso restrito apenas para administradores.';
    $_SESSION['toast_type'] = 'danger';
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de Pedidos - Seven</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
    <?php if (isset($_SESSION['usuario_nivel'])): ?>
    <script>
        localStorage.setItem('usuario_nome', '<?php echo addslashes($_SESSION['usuario_nome'] ?? ""); ?>');
        localStorage.setItem('usuario_email', '<?php echo addslashes($_SESSION['usuario_email'] ?? ""); ?>');
        localStorage.setItem('usuario_nivel', '<?php echo addslashes($_SESSION['usuario_nivel'] ?? ""); ?>');
    </script>
    <?php endif; ?>
</head>
<body>
    <?php $header_class = ($_SESSION['usuario_nivel'] == 'Operador') ? 'operator-header' : 'blue-header'; ?>
    <div class="<?php echo $header_class; ?> pb-4" style="min-height: 250px;">
        <?php if ($_SESSION['usuario_nivel'] != 'Operador'): ?>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background: transparent;">
          <div class="container-fluid">
            <a class="navbar-brand font-weight-bold" href="index.php">Painel Seven - <?php echo $_SESSION['usuario_nivel']; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
        	      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
	        <li class="nav-item">
	          <a class="nav-link" aria-current="page" href="index.php?page=painel-pedidos">Fila de Pedidos</a>
	        </li>
            <?php if ($_SESSION['usuario_nivel'] == 'Admin'): ?>
            <li class="nav-item">
	          <a class="nav-link" href="index.php?page=historico-pedidos">Histórico</a>
	        </li>
            <li class="nav-item">
	          <a class="nav-link" href="index.php?page=listar-usuario">Usuários</a>
	        </li>
            <?php endif; ?>

            <li class="nav-item">
	          <a class="nav-link" href="index.php?page=listar-sala">Salas</a>
	        </li>

            <li class="nav-item">
	          <a class="nav-link" href="index.php?page=listar-cardapio">Cardápio</a>
	        </li>
	      </ul>
	      <div class="d-flex align-items-center text-white">
            <span class="me-3">Olá, <strong><?php echo $_SESSION['usuario_nome']; ?></strong></span>
	        <a href="?acao=logout" class="btn btn-outline-light btn-sm">Sair</a>
	      </div>
	    </div>
	  </div>
	</nav>
    <?php else: ?>
        <div class="container pt-4 text-center text-white">
            <h4 class="mb-0 fw-bold">Painel Operador</h4>
            <small class="text-white-50">Olá, <?php echo $_SESSION['usuario_nome']; ?></small>
        </div>
    <?php endif; ?>
    </div>

	<div class="container mb-5 pb-5 main-card-container">
		<div class="row">
			<div class="col">
				<div class="custom-card">
				<?php
					switch ($page) {
						case 'cadastrar-usuario': include('cadastrar-usuario.php'); break;
						case 'listar-usuario': include('listar-usuario.php'); break;
						case 'editar-usuario': include('editar-usuario.php'); break;
						case 'salvar-usuario': include('salvar-usuario.php'); break;

						case 'cadastrar-cardapio': include('cadastrar-cardapio.php'); break;
						case 'listar-cardapio': include('listar-cardapio.php'); break;
						case 'editar-cardapio': include('editar-cardapio.php'); break;
						case 'salvar-cardapio': include('salvar-cardapio.php'); break;
                        
                        case 'cadastrar-sala': include('cadastrar-sala.php'); break;
                        case 'listar-sala': include('listar-sala.php'); break;
                        case 'salvar-sala': include('salvar-sala.php'); break;
                        
                        case 'painel-pedidos': include('painel-pedidos.php'); break;
                        case 'historico-pedidos': include('historico-pedidos.php'); break;
                        case 'acao-pedido': include('acao-pedido.php'); break;

						default:
							include('painel-pedidos.php');
					}
				?>
				</div>
			</div>

		</div>
	</div>

	<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    
    <?php 
    if (isset($_SESSION['usuario_nivel']) && $_SESSION['usuario_nivel'] == 'Operador') {
        include('operador-dock.php');
        echo '<style>body { padding-bottom: 90px; }</style>';
    }

    if (isset($is_admin_flow_from_mobile) && $is_admin_flow_from_mobile) {
        $current_page = 'cliente-painel'; 
        include('cliente-dock.php');
        echo '<style>body { padding-bottom: 90px; } .custom-navbar { border-radius: 0; margin-top: 0; }</style>';
    }
    ?>
    
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

    
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 text-center">
                    <p class="mb-0 fs-5">Tem certeza que deseja excluir este item?</p>
                    <p class="text-muted small">Essa ação não poderá ser desfeita.</p>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger px-4 py-2">Sim, Excluir</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function confirmDelete(url) {
            document.getElementById('confirmDeleteBtn').href = url;
            var myModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            myModal.show();
        }
    </script>

    <div class="modal fade" id="cancelConfirmModal" tabindex="-1" aria-labelledby="cancelConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-warning text-dark border-0">
                    <h5 class="modal-title" id="cancelConfirmModalLabel">Confirmar Cancelamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 text-center">
                    <p class="mb-0 fs-5">Tem certeza que deseja cancelar este pedido?</p>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal">Voltar</button>
                    <a href="#" id="confirmCancelBtn" class="btn btn-danger px-4 py-2">Sim, Cancelar</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function confirmCancel(url) {
            document.getElementById('confirmCancelBtn').href = url;
            var myModal = new bootstrap.Modal(document.getElementById('cancelConfirmModal'));
            myModal.show();
        }
    </script>
</body>
</html>