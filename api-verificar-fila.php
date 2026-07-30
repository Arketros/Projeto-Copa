<?php
date_default_timezone_set('America/Sao_Paulo');
include('config.php');

$hoje = date('Y-m-d');
$sql = "SELECT id_solicitacao, status FROM solicitacao WHERE status != 'Finalizado' AND data_hora LIKE '{$hoje}%' ORDER BY id_solicitacao ASC";
$res = $conn->query($sql);

$fingerprint = "";
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_object()) {
        $fingerprint .= $row->id_solicitacao . "-" . $row->status . "|";
    }
}
echo md5($fingerprint);
?>
