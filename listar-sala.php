<script src="js/qrcode.min.js"></script>
<script>
    function addLogoToSVG(svgString, size) {
        var center = size / 2;
        var rectW = size * 0.36;
        var rectH = size * 0.16;
        var fontSize = size * 0.10;
        var logoXML = '<g transform="translate(' + center + ', ' + center + ')">' +
            '<rect x="' + (-rectW / 2) + '" y="' + (-rectH / 2) + '" width="' + rectW + '" height="' + rectH + '" fill="white" rx="3"/>' +
            '<text x="0" y="2" font-family="Arial, Helvetica, sans-serif" font-size="' + fontSize + '" font-weight="900" fill="#003cff" text-anchor="middle" dominant-baseline="middle">Seven.</text>' +
            '</g>';
        return svgString.replace('</svg>', logoXML + '</svg>');
    }

    function downloadSVG(url, filename) {
        var svgData = new QRCode({ content: url, padding: 4, width: 256, height: 256, color: "#000000", background: "#ffffff", ecl: "H" }).svg();
        svgData = addLogoToSVG(svgData, 256);
        var blob = new Blob([svgData], { type: "image/svg+xml;charset=utf-8" });
        var blobUrl = URL.createObjectURL(blob);
        var link = document.createElement("a");
        link.href = blobUrl;
        link.download = filename + ".svg";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
<?php $is_admin = ($_SESSION['usuario_nivel'] == 'Admin'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="m-0">Salas</h1>
    <?php if ($is_admin): ?>
        <button class="btn btn-primary" onclick="openSalaModal()">+ Cadastrar Nova</button>
    <?php endif; ?>
</div>
<?php
$sql = "SELECT * FROM sala WHERE status_sala != 'Excluído'";
$res = $conn->query($sql);
$qtd = $res->num_rows;

if ($qtd > 0) {
    print "<div class='row'>";
    while ($row = $res->fetch_object()) {

        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $url_qr = $protocol . "://" . $host . $path . "/?sala=" . $row->hash_url;

        print "
            <div class='col-md-6 col-lg-4 mb-4'>
                <div class='card shadow-sm border-0 h-100' style='border-radius: 12px;'>
                    <div class='card-body text-center d-flex flex-column'>
                        <h5 class='card-title fw-bold text-primary mb-1'>{$row->nome_sala}</h5>
                        <p class='text-muted small mb-3'>ID da Sala: {$row->id_sala}</p>
                        
                        <div id='qr-{$row->id_sala}' class='d-flex justify-content-center mb-3'></div>
                        <script>
                          var svg_{$row->id_sala} = new QRCode({ content: '{$url_qr}', padding: 0, width: 140, height: 140, color: '#000000', background: '#ffffff', ecl: 'H' }).svg();
                          svg_{$row->id_sala} = addLogoToSVG(svg_{$row->id_sala}, 140);
                          document.getElementById('qr-{$row->id_sala}').innerHTML = svg_{$row->id_sala};
                        </script>
                        
                        <div class='mb-3'>
                            <a href='{$url_qr}' target='_blank' class='small text-decoration-none bg-light px-2 py-1 rounded text-break' style='font-size: 0.8rem;'>
                                {$url_qr}
                            </a>
                        </div>
                        
                        <div class='mt-auto'>
                            <button class='btn btn-sm btn-outline-dark w-100 mb-2' onclick=\"downloadSVG('{$url_qr}', 'qrcode-sala-{$row->id_sala}')\">
                                Baixar QR Code SVG
                            </button>
            ";

        if ($is_admin) {
            print "
                            <div class='d-flex gap-2 mt-2 pt-2 border-top'>
                                <button class='btn btn-success flex-fill' onclick=\"location.href='?page=editar-sala&id_sala={$row->id_sala}';\">Editar</button>
                                <button class='btn btn-danger flex-fill' onclick=\"confirmDelete('?page=salvar-sala&acao=excluir&id_sala={$row->id_sala}')\">Excluir</button>
                            </div>
                ";
        }

        print "
                        </div>
                    </div>
                </div>
            </div>
            ";
    }
    print "</div>";
} else {
    print "<p class='alert alert-warning'>Não encontrou resultados!</p>";
}
?>


<div id="sheetBackdropSala" class="sheet-backdrop" onclick="closeSalaModal()"></div>
<div id="detailsModalSala" class="bottom-sheet">
    <div class="bottom-sheet-header">
        <div class="bottom-sheet-drag-handle"></div>
        <h5 class="mb-0">Cadastrar Nova Sala</h5>
    </div>
    <div class="bottom-sheet-content">
        <form action="?page=salvar-sala" method="POST">
            <input type="hidden" name="acao" value="cadastrar">
            <div class="mb-4">
                <label class="form-label">Nome da Sala</label>
                <input type="text" name="nome_sala" class="form-control" required placeholder="Ex: Sala Diretoria">
            </div>
            <div class="mb-4">
                <label class="form-label">Capacidade (Quantidade de Cadeiras)</label>
                <input type="number" name="capacidade" class="form-control" value="6" min="1" max="20" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-3">Salvar Sala</button>
            <button type="button" class="btn btn-outline-secondary w-100 py-2 mt-2"
                onclick="closeSalaModal()">Cancelar</button>
        </form>
    </div>
</div>

<script>
    function openSalaModal() {
        document.getElementById('detailsModalSala').classList.add('open');
        document.getElementById('sheetBackdropSala').classList.add('open');
    }

    function closeSalaModal() {
        document.getElementById('detailsModalSala').classList.remove('open');
        document.getElementById('sheetBackdropSala').classList.remove('open');
    }
</script>