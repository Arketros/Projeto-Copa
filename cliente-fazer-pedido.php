<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fazer Pedido - Seven</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="blue-header">
        <?php
        if (!isset($_SESSION['cliente_email'])) { header("Location: index.php"); exit; }
        
        $hash = isset($_SESSION['sala_hash']) ? $_SESSION['sala_hash'] : '';
        $sql = "SELECT id_sala, nome_sala, capacidade FROM sala WHERE hash_url = '{$hash}'";
        $res = $conn->query($sql);
        
        if (!$res || $res->num_rows == 0) {
            echo "</div><div class='container mt-5'><div class='alert alert-danger'>Erro: Sala não encontrada. Por favor, leia o QR Code da mesa novamente.</div></div></body></html>";
            exit;
        }
        
        $sala = $res->fetch_object();

        $capacidade = isset($sala->capacidade) ? (int) $sala->capacidade : 6;
        $cadeiras_cima = ceil($capacidade / 2);
        $cadeiras_baixo = floor($capacidade / 2);
        ?>
        <h4><?php echo $sala->nome_sala; ?></h4>
        <p>Olá, <?php echo explode('@', $_SESSION['cliente_email'])[0]; ?>! Vamos fazer o pedido.</p>
    </div>

    <div class="container mb-5 pb-5">
        <div class="custom-card floating-card">
            <form id="pedidoForm" action="cliente-processar.php" method="POST">
                <input type="hidden" name="id_sala" value="<?php echo $sala->id_sala; ?>">
                
                <!-- Stepper Indicator -->
                <div class="stepper-wrapper mb-4 text-center">
                    <div class="stepper-item active" id="step-ind-1">
                        <div class="step-counter">1</div>
                    </div>
                    <div class="stepper-item" id="step-ind-2">
                        <div class="step-counter">2</div>
                    </div>
                    <div class="stepper-item" id="step-ind-3">
                        <div class="step-counter">3</div>
                    </div>
                </div>

                <!-- STEP 1: Meeting Info -->
                <div id="step1" class="step-section active">
                    <div class="d-flex align-items-center mb-4">
                        <button type="button" class="btn btn-link text-decoration-none p-0 me-3 text-dark" onclick="window.location.href='index.php?page=cliente-meus-pedidos'"><i data-lucide="arrow-left"></i> Voltar</button>
                        <h5 class="mb-0 text-center flex-grow-1" style="margin-left: -40px;">Detalhes da Reunião</h5>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tipo de Reunião</label>
                        <select name="tipo_encontro" id="tipo_encontro_select" class="form-select form-select-lg">
                            <option value="Normal">Reunião Normal</option>
                            <option value="Executiva">Reunião Executiva</option>
                            <option value="Treinamento">Treinamento</option>
                            <option value="AGM">AGM</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold d-block text-center">Quantas pessoas?</label>
                        <input type="number" name="quantidade_pessoas" id="qtd_pessoas_input" class="form-control form-control-lg text-center mb-3 fw-bold fs-3" style="max-width: 150px; margin: 0 auto;" min="2" value="2" onchange="syncChairs()">
                        
                        <div class="text-center text-muted small mb-3">Ou clique nas cadeiras da mesa:</div>
                        <div class="meeting-room mb-2">
                            <div class="chair-row">
                                <?php for ($i = 0; $i < $cadeiras_cima; $i++): ?>
                                    <div class="chair" onclick="toggleChair(this)"></div>
                                <?php endfor; ?>
                            </div>
                            <div class="oval-table">Mesa</div>
                            <div class="chair-row">
                                <?php for ($i = 0; $i < $cadeiras_baixo; $i++): ?>
                                    <div class="chair" onclick="toggleChair(this)"></div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary w-100 py-3 font-weight-bold" onclick="validateStep1()">Avançar para o Cardápio <i data-lucide="arrow-right" class="ms-2" style="width:18px;"></i></button>
                </div>

                <!-- STEP 2: Menu Items -->
                <div id="step2" class="step-section">
                    <div class="d-flex align-items-center mb-4">
                        <button type="button" class="btn btn-link text-decoration-none p-0 me-3 text-dark" onclick="nextStep(1)"><i data-lucide="arrow-left"></i> Voltar</button>
                        <h5 class="mb-0 text-center flex-grow-1" style="margin-left: -40px;">Cardápio</h5>
                    </div>

                    <div class="category-pills">
                        <button type="button" class="category-pill active" onclick="filterCategory('Todos', this)">Tudo</button>
                        <button type="button" class="category-pill d-flex align-items-center" onclick="filterCategory('Bebida', this)"><i data-lucide="coffee" style="width: 16px; height: 16px; margin-right: 6px;"></i> Bebidas</button>
                        <button type="button" class="category-pill d-flex align-items-center" onclick="filterCategory('Lanche', this)"><i data-lucide="cookie" style="width: 16px; height: 16px; margin-right: 6px;"></i> Lanches</button>
                    </div>

                    <div class="menu-list mb-4">
                        <?php
                        $sql = "SELECT * FROM cardapio WHERE situacao_cardapio='Ativo' ORDER BY total_pedidos DESC, nome_cardapio ASC";
                        $res = $conn->query($sql);
                        if ($res && $res->num_rows > 0) {
                            while ($row = $res->fetch_object()) {
                                ?>
                                <label class="selectable-card w-100" data-category="<?php echo $row->categoria_cardapio; ?>" data-name="<?php echo htmlspecialchars($row->nome_cardapio); ?>" onclick="toggleItemSelect(this, event)">
                                    <div class="card-left">
                                        <strong class="d-block" style="font-size: 1.1rem;"><?php echo $row->nome_cardapio; ?></strong>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="qty-control" onclick="event.stopPropagation();">
                                            <button type="button" class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                            <input type="number" name="itens[<?php echo $row->id_cardapio; ?>]" class="qty-input item-qty-val" value="0" min="0" onchange="checkCardState(this)">
                                            <button type="button" class="qty-btn" onclick="updateQty(this, 1)">+</button>
                                        </div>
                                        <?php if (!empty($row->imagem_url)): ?>
                                            <div class="card-right-image" style="background-image: url('<?php echo $row->imagem_url; ?>'); margin-left: 15px;"></div>
                                        <?php endif; ?>
                                    </div>
                                </label>
                                <?php
                            }
                        } else {
                            echo "<div class='alert alert-warning'>Nenhum item disponível no momento.</div>";
                        }
                        ?>
                    </div>

                    <button type="button" class="btn btn-primary w-100 py-3 font-weight-bold" onclick="goToStep3()">Ver Resumo do Pedido <i data-lucide="arrow-right" class="ms-2" style="width:18px;"></i></button>
                </div>

                <!-- STEP 3: Summary -->
                <div id="step3" class="step-section">
                    <div class="d-flex align-items-center mb-4">
                        <button type="button" class="btn btn-link text-decoration-none p-0 me-3 text-dark" onclick="nextStep(2)"><i data-lucide="arrow-left"></i> Voltar</button>
                        <h5 class="mb-0 text-center flex-grow-1" style="margin-left: -40px;">Resumo</h5>
                    </div>

                    <div class="comanda-receipt mb-4" id="comandaContent">
                        <!-- Populated by JS -->
                    </div>
                    
                    <div id="emptyOrderAlert" class="alert alert-danger d-none text-center">Você não selecionou nenhum item do cardápio!</div>

                    <button type="submit" class="btn btn-success w-100 py-3 font-weight-bold fs-5 shadow" id="btnConfirmarPedido">Enviar Pedido <i data-lucide="check" class="ms-2" style="width:20px;"></i></button>
                </div>

            </form>
        </div>
    </div>

    <?php include('cliente-dock.php'); ?>

    <script>
        // -- Navigation --
        function validateStep1() {
            let qtd = parseInt(document.getElementById('qtd_pessoas_input').value) || 0;
            if (qtd < 2) {
                alert("Uma reunião exige no mínimo 2 pessoas.");
                return;
            }
            nextStep(2);
        }

        function updateStepper(step) {
            document.querySelectorAll('.stepper-item').forEach((item, index) => {
                let s = index + 1;
                item.classList.remove('active', 'completed');
                if (s < step) item.classList.add('completed');
                if (s === step) item.classList.add('active');
            });
        }

        function nextStep(step) {
            document.querySelectorAll('.step-section').forEach(el => el.classList.remove('active'));
            document.getElementById('step' + step).classList.add('active');
            updateStepper(step);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // -- Step 1: Chairs and Qty --
        function toggleChair(element) {
            element.classList.toggle('selected');
            let count = document.querySelectorAll('.chair.selected').length;
            document.getElementById('qtd_pessoas_input').value = count;
        }

        function syncChairs() {
            let val = parseInt(document.getElementById('qtd_pessoas_input').value) || 0;
            let currentChairs = document.querySelectorAll('.chair').length;
            let containerCima = document.querySelectorAll('.chair-row')[0];
            let containerBaixo = document.querySelectorAll('.chair-row')[1];
            let maxCapacidade = <?php echo $capacidade; ?>;
            
            if (val > currentChairs) {
                let diff = val - currentChairs;
                for (let i=0; i<diff; i++) {
                    let newChair = document.createElement('div');
                    newChair.className = 'chair chair-extra';
                    newChair.onclick = function() { toggleChair(this); };
                    if (containerCima.children.length <= containerBaixo.children.length) {
                        containerCima.appendChild(newChair);
                    } else {
                        containerBaixo.appendChild(newChair);
                    }
                }
            } else if (val < currentChairs && currentChairs > maxCapacidade) {
                let targetChairs = Math.max(maxCapacidade, val);
                let diff = currentChairs - targetChairs;
                for (let i=0; i<diff; i++) {
                    let extras = document.querySelectorAll('.chair-extra');
                    if (extras.length > 0) {
                        extras[extras.length - 1].remove();
                    }
                }
            }
            
            let chairs = document.querySelectorAll('.chair');
            chairs.forEach((chair, index) => {
                if (index < val) {
                    chair.classList.add('selected');
                } else {
                    chair.classList.remove('selected');
                }
            });
        }

        // -- Step 2: Items --
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

        function updateQty(btn, delta) {
            let input = btn.parentElement.querySelector('.qty-input');
            let newVal = parseInt(input.value) + delta;
            if (newVal < 0) newVal = 0;
            input.value = newVal;
            checkCardState(input);
        }

        function checkCardState(input) {
            let card = input.closest('.selectable-card');
            if (parseInt(input.value) > 0) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        }

        function toggleItemSelect(card, event) {
            if (event.target.closest('.qty-control')) return;
            let input = card.querySelector('.qty-input');
            if (parseInt(input.value) === 0) {
                input.value = 1;
                card.classList.add('selected');
            } else {
                input.value = 0;
                card.classList.remove('selected');
            }
        }

        // -- Step 3: Summary --
        function goToStep3() {
            let tipo = document.getElementById('tipo_encontro_select');
            let nomeTipo = tipo.options[tipo.selectedIndex].text;
            let qtdPessoas = parseInt(document.getElementById('qtd_pessoas_input').value) || 0;
            
            let itemsHtml = '';
            let hasItems = false;
            
            document.querySelectorAll('.selectable-card.selected').forEach(card => {
                let name = card.getAttribute('data-name');
                let qty = parseInt(card.querySelector('.qty-input').value) || 0;
                if (qty > 0) {
                    hasItems = true;
                    itemsHtml += `<div class="comanda-row"><span>${qty}x ${name}</span></div>`;
                }
            });

            let comandaHtml = `
                <div class="comanda-header">
                    <h4>Mesa: <?php echo $sala->nome_sala; ?></h4>
                    <div class="small mt-1">Data: ${new Date().toLocaleDateString('pt-BR')} ${new Date().toLocaleTimeString('pt-BR', {hour: '2-digit', minute:'2-digit'})}</div>
                </div>
                <div class="mb-3">
                    <div class="comanda-row fw-bold"><span>Reunião:</span> <span>${nomeTipo}</span></div>
                    <div class="comanda-row fw-bold"><span>Pessoas:</span> <span>${qtdPessoas} pes.</span></div>
                </div>
                <div class="comanda-divider"></div>
                <div class="mb-2 fw-bold text-center">ITENS DO PEDIDO</div>
                ${hasItems ? itemsHtml : '<div class="text-center text-muted small my-3">Nenhum item selecionado</div>'}
                <div class="comanda-divider"></div>
                <div class="text-center small mt-3">Solicitante: <?php echo explode('@', $_SESSION['cliente_email'])[0]; ?></div>
            `;
            
            document.getElementById('comandaContent').innerHTML = comandaHtml;
            
            if (!hasItems) {
                document.getElementById('emptyOrderAlert').classList.remove('d-none');
                document.getElementById('btnConfirmarPedido').disabled = true;
            } else {
                document.getElementById('emptyOrderAlert').classList.add('d-none');
                document.getElementById('btnConfirmarPedido').disabled = false;
            }
            
            nextStep(3);
        }

        // Initialize chairs on load
        window.onload = function() {
            syncChairs();
        };
    </script>
</body>
</html>