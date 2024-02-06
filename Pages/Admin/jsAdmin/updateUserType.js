document.getElementById('checkExample').addEventListener('change', function() {
    var idUser = document.getElementById('id_user_hidden').value;
    var checked = this.checked;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ativar_administrador.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            } else {
                console.error('Erro ao processar a solicitação');
            }
        }
    };
    xhr.send('idUser=' + idUser + '&checked=' + checked);
});