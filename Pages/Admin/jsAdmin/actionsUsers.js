//Fazer chamada AJAX para enviar o evento ao PHP ao ser marcado o check input de "Tornar usuário administrador"

document.getElementById('check-admin').addEventListener('change', function () {
    var idUser = document.getElementById('id_user_hidden').value;
    var checked = this.checked;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'adminDashboard.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
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

document.querySelector('#form-action-users button[type="submit"]').addEventListener('click', function (event) {
    event.preventDefault(); // Impede o envio do formulário

    var idUser = document.getElementById('id_user_hidden').value;
    document.querySelector('#form-action-users input[name="id_user"]').value = idUser;

    // Fazer solicitação AJAX para desativar o usuário
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'adminDashboard.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Remover a linha da tabela, do usuário no qual foi desativado
                var tableRow = document.querySelector('tbody').querySelector('tr[data-id="' + idUser + '"]');
                if (tableRow) {
                    tableRow.remove();
                }
            } else {
                console.error('Erro ao desativar o usuário');
            }
        }
    };
    xhr.send('id_user=' + idUser + '&action=desativar');

    // Fechar o modal após o envio do formulário
    var modal = document.getElementById('modalAdmin');
    var modalBackdrop = document.querySelector('.modal-backdrop');

    if (modal && modalBackdrop) {
        modal.style.display = 'none'; // Oculta o modal
        modalBackdrop.remove(); // Remove o backdrop do modal
    }
});


document.querySelectorAll('.alterar-usuario-btn').forEach(button => {
    button.addEventListener('click', function () {
        var idUser = this.getAttribute('data-id-user');
        document.getElementById('id_user_hidden').value = idUser;

        // Recarregar página ao fechar modal
        document.getElementById('modalAdmin').addEventListener('hidden.bs.modal', function () {
            location.reload();
        });
    });
});


