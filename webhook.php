<?php
// Webhook que recebe confirmação automática do pagamento
$data = json_decode(file_get_contents("php://input"), true);

// Verifica se foi pago
if (!empty($data["pix"][0]["endToEndId"])) {
    $nome = $data["pix"][0]["txid"]; // usamos o txid como identificador do participante
    file_get_contents("https://seusite.com/bolao-pix/server/enviar-telegram.php?nome=" . urlencode($nome));
}

http_response_code(200);
?>