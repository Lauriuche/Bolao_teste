const TELEGRAM = {
  token: "8307035824:AAFsKe4l1WgbZI1uez-n06Vt-TYiuhZLMt8",
  chat_id: "861365063"
};

// 🔗 Link de pagamento fixo (pode alterar quando quiser)
const LINK_PAGAMENTO = "https://cofrinhos.picpay.com/bGexsvF1cml1Y2hlLzgvYm9sYW8vREVGQVVMVA/transferir-outro-banco";

document.getElementById("btn").addEventListener("click", async () => {
  const nome = document.getElementById("nome").value.trim();
  const telefone = document.getElementById("telefone").value.trim();
  const valor = document.getElementById("valor").textContent;

  if (!nome || !telefone) {
    alert("Preencha todos os campos antes de continuar!");
    return;
  }

  // Envia para o Telegram antes de redirecionar
  const message = `🎟️ *Novo Cadastro no Bolão*\n\n👤 *Nome:* ${nome}\n📞 *Telefone:* ${telefone}\n💰 *Valor:* R$ ${valor}\n🕐 *Status:* Aguardando pagamento`;
  const url = `https://api.telegram.org/bot${TELEGRAM.token}/sendMessage`;

  await fetch(url, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ chat_id: TELEGRAM.chat_id, text: message, parse_mode: "Markdown" })
  });

  // Redireciona para o link de pagamento
  window.location.href = LINK_PAGAMENTO;
});
