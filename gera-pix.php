<?php
$modo = 'producao';  
$client_id = "SEU_CLIENT_ID";
$client_secret = "SEU_CLIENT_SECRET";
$chave_pix = "SUA_CHAVE_PIX";
$certificado = __DIR__ . "/producao.pem";

$nome = $_POST['nome'];
$telefone = $_POST['telefone'];

$url_token = ($modo==='sandbox') ? "https://api-sandbox.efi.com.br/oauth/token" : "https://api.efi.com.br/oauth/token";
$url_pix   = ($modo==='sandbox') ? "https://api-sandbox.efi.com.br/v2/cob" : "https://api.efi.com.br/v2/cob";

// Solicita token
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url_token,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_USERPWD => "$client_id:$client_secret",
    CURLOPT_POSTFIELDS => "grant_type=client_credentials",
]);
if($modo==='producao'){
    curl_setopt($curl,CURLOPT_SSLCERT,$certificado);
    curl_setopt($curl,CURLOPT_SSLKEY,$certificado);
}
$res_token = curl_exec($curl);
$token = json_decode($res_token)->access_token;
curl_close($curl);

// Cria cobrança
$valor = "85.00";
$payload = [
    "calendario"=>["expiracao"=>3600],
    "valor"=>["original"=>$valor],
    "chave"=>$chave_pix,
    "solicitacaoPagador"=>"Pagamento bolão - $nome"
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL=>$url_pix,
    CURLOPT_RETURNTRANSFER=>true,
    CURLOPT_POST=>true,
    CURLOPT_HTTPHEADER=>["Authorization: Bearer $token","Content-Type: application/json"],
    CURLOPT_POSTFIELDS=>json_encode($payload)
]);
if($modo==='producao'){
    curl_setopt($curl,CURLOPT_SSLCERT,$certificado);
    curl_setopt($curl,CURLOPT_SSLKEY,$certificado);
}

$res_pix = json_decode(curl_exec($curl),true);
curl_close($curl);

echo json_encode([
    "qr_code"=>$res_pix['pixCopiaEColaImagem'] ?? $res_pix['imagemQrcode'],
    "copia_cola"=>$res_pix['pixCopiaECola'] ?? "Erro"
]);
