<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fazer Pedido - Seven</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <style>
        .menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .item-info {
            flex-grow: 1;
        }

        .item-qtd {
            width: 80px;
        }
    </style>
</head>

<body>
    <div class="blue-header">
        <?php
        $hash = $_SESSION['sala_hash'];
        $sql = "SELECT id_sala, nome_sala, capacidade FROM sala WHERE hash_url = '{$hash}'";
        $res = $conn->query($sql);
        $sala = $res->fetch_object();


        $capacidade = isset($sala->capacidade) ? (int) $sala->capacidade : 6;
        $cadeiras_cima = ceil($capacidade / 2);
        $cadeiras_baixo = floor($capacidade / 2);
        ?>
        <h4><?php echo $sala->nome_sala; ?></h4>
        <p>Olá, <?php echo $_SESSION['cliente_email']; ?>! O que deseja pedir?</p>
    </div>

    <div class="container mb-5 pb-5">
        <div class="custom-card floating-card">
            <form id="pedidoForm" action="cliente-processar.php" method="POST">
                <input type="hidden" name="id_sala" value="<?php echo $sala->id_sala; ?>">

                <h5 class="mb-3">Cardápio</h5>
                <div class="category-pills">
                    <button type="button" class="category-pill active"
                        onclick="filterCategory('Todos', this)">Tudo</button>
                    <button type="button" class="category-pill d-flex align-items-center"
                        onclick="filterCategory('Bebida', this)"><i data-lucide="coffee"
                            style="width: 16px; height: 16px; margin-right: 6px;"></i> Bebidas</button>
                    <button type="button" class="category-pill d-flex align-items-center"
                        onclick="filterCategory('Lanche', this)"><i data-lucide="cookie"
                            style="width: 16px; height: 16px; margin-right: 6px;"></i> Lanches</button>
                </div>
                <div class="menu-list mb-4">
                    <?php

                    $sql = "SELECT * FROM cardapio WHERE situacao_cardapio='Ativo' ORDER BY total_pedidos DESC, nome_cardapio ASC";
                    $res = $conn->query($sql);

                    if ($res && $res->num_rows > 0) {
                        while ($row = $res->fetch_object()) {
                            ?>
                            <label class="selectable-card w-100" data-category="<?php echo $row->categoria_cardapio; ?>"
                                onclick="toggleItemSelect(this, event)">
                                <div class="card-left">
                                    <div class="item-check">
                                        <input type="checkbox" name="itens[<?php echo $row->id_cardapio; ?>]" value="1"
                                            class="d-none item-checkbox">
                                        <i data-lucide="check-circle" class="check-icon"></i>
                                    </div>
                                    <strong class="d-block"
                                        style="font-size: 1.1rem;"><?php echo $row->nome_cardapio; ?></strong>
                                </div>
                                <?php if (!empty($row->imagem_url)): ?>
                                    <div class="card-right-image" style="background-image: url('<?php echo $row->imagem_url; ?>');">
                                    </div>
                                <?php endif; ?>
                            </label>
                            <?php
                        }
                    } else {
                        echo "<div class='alert alert-warning'>Nenhum item disponível no momento.</div>";
                    }
                    ?>
                </div>

                <button type="button" id="btn-reuniao-info"
                    class="btn btn-outline-primary w-100 py-2 mb-3 d-flex align-items-center justify-content-center"
                    onclick="openDetailsModal()">
                    <i data-lucide="settings-2" class="me-2" style="width:18px; height:18px;"></i> <span
                        id="reuniao-info-text">Informações da Reunião (Opcional)</span>
                </button>

                <button type="submit" class="btn btn-primary w-100 py-3 font-weight-bold">Concluir Pedido</button>
            </form>
        </div>
    </div>


    <div id="sheetBackdrop" class="sheet-backdrop" onclick="closeDetailsModal()"></div>
    <div id="detailsModal" class="bottom-sheet">
        <div class="bottom-sheet-header">
            <div class="bottom-sheet-drag-handle"></div>
            <h5 class="mb-0">Detalhes da Reunião</h5>
        </div>
        <div class="bottom-sheet-content">
            <label class="form-label text-center d-block">Quantas pessoas?</label>
            <input type="hidden" name="quantidade_pessoas" id="qtd_pessoas_input" value="0" form="pedidoForm">

            <div class="meeting-room mb-2">
                <div class="chair-row">
                    <?php for ($i = 0; $i < $cadeiras_cima; $i++): ?>
                        <div class="chair" onclick="toggleChair(this)"></div>
                    <?php endfor; ?>
                </div>
                <div class="oval-table">
                    Mesa
                </div>
                <div class="chair-row">
                    <?php for ($i = 0; $i < $cadeiras_baixo; $i++): ?>
                        <div class="chair" onclick="toggleChair(this)"></div>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="text-center mb-4 small text-muted">
                <span id="qtd_display">0</span> pessoa(s) selecionada(s)
            </div>

            <div class="mb-4">
                <label class="form-label">Tipo de Reunião</label>
                <select name="tipo_encontro" id="tipo_encontro_select" class="form-select" form="pedidoForm">
                    <option value="">Não informado (Opcional)</option>
                    <option value="Normal">Reunião Normal</option>
                    <option value="Executiva">Reunião Executiva</option>
                    <option value="Treinamento">Treinamento</option>
                    <option value="AGM">AGM</option>
                </select>
            </div>

            <button type="button" class="btn btn-primary w-100 py-3 mb-4" onclick="closeDetailsModal()">Pronto</button>
        </div>
    </div>

    <?php include('cliente-dock.php'); ?>

    <script>
        function toggleChair(element) {
            element.classList.toggle('selected');
            updateCount();
        }

        function updateCount() {
            let count = document.querySelectorAll('.chair.selected').length;
            if (count === 0) {
            }
            document.getElementById('qtd_pessoas_input').value = count;
            document.getElementById('qtd_display').innerText = count;
        }

        function openDetailsModal() {
            document.getElementById('detailsModal').classList.add('open');
            document.getElementById('sheetBackdrop').classList.add('open');
        }

        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.remove('open');
            document.getElementById('sheetBackdrop').classList.remove('open');

            let qtd = parseInt(document.getElementById('qtd_pessoas_input').value) || 0;
            let selectTipo = document.getElementById('tipo_encontro_select');
            let btnText = "";

            if (qtd > 0) {
                btnText = qtd + " pessoa(s)";
            }

            if (selectTipo.value !== "") {
                if (btnText !== "") {
                    btnText += " • ";
                }
                btnText += selectTipo.options[selectTipo.selectedIndex].text;
            }

            let btnElement = document.getElementById('btn-reuniao-info');

            if (btnText === "") {
                document.getElementById('reuniao-info-text').innerText = "Informações da Reunião (Opcional)";
                btnElement.classList.remove('btn-primary');
                btnElement.classList.add('btn-outline-primary');
            } else {
                document.getElementById('reuniao-info-text').innerText = btnText;
                btnElement.classList.add('btn-primary');
                btnElement.classList.remove('btn-outline-primary');
            }
        }

        function filterCategory(cat, btn) {
            document.querySelectorAll(".category-pill").forEach(p => p.classList.remove("active"));
            btn.classList.add("active");

            document.querySelectorAll(".selectable-card").forEach(card => {
                if (cat === "Todos" || card.getAttribute("data-category") === cat) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        }

        function toggleItemSelect(element, event) {
            let checkbox = element.querySelector('.item-checkbox');

            setTimeout(() => {
                if (checkbox.checked) {
                    element.classList.add('selected');
                } else {
                    element.classList.remove('selected');
                }
            }, 10);
        }
    </script>
</body>

</html>