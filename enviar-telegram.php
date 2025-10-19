<?php
$token = "8307035824:AAFsKe4l1WgbZI1uez-n06Vt-TYiuhZLMt8";
$chat_id = "861365063";
$nome = $_GET['nome'];

$msg = "✅ Novo participante confirmado no bolão!\nNome: $nome";

file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($msg));
?>