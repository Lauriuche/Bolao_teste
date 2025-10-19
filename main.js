document.getElementById('btnParticipar').addEventListener('click', async () => {
  const nome = document.getElementById('nome').value.trim();
  const telefone = document.getElementById('telefone').value.trim();

  if (!nome || !telefone) {
    alert('Preencha nome e telefone!');
    return;
  }

  // Chama a API PHP para gerar Pix
  const formData = new FormData();
  formData.append('nome', nome);
  formData.append('telefone', telefone);

  const response = await fetch('server/gerar-pix.php', {
    method: 'POST',
    body: formData
  });

  const data = await response.json();

  if (data.qr_code) {
    document.getElementById('pixArea').style.display = 'block';
    document.getElementById('qrCode').src = data.qr_code;
    document.getElementById('copiaCola').textContent = data.copia_cola;
  } else {
    alert('Erro ao gerar QR Code, tente novamente.');
  }
});