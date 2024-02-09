//Fazendo chamada AJAX para enviar o evento ao PHP ao ser marcado o check input de "Tornar usuário administrador"
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

    // Recarregar página ao fechar o modal de desativar usuário
    document.getElementById('modalAdmin').addEventListener('hidden.bs.modal', function () {
        location.reload();
    });
});

document.querySelector('#form-action-users button[type="submit"]').addEventListener('click', function (event) {
    event.preventDefault(); // Impede o envio do formulário

    var idUser = document.getElementById('id_user_hidden').value;
    document.querySelector('#form-action-users input[name="id_user"]').value = idUser;

    // Fazendo solicitação AJAX para desativar o usuário
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

//Excluindo o usuário ao clicar no botão 'Excluir' de acordo com o ID, e fazendo uma chamada AJAX para enviar o evento ao PHP
document.getElementById('confirmarExclusaoBtn').addEventListener('click', function () {
    var idUser = document.getElementById('id_user_hidden').value; 
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'adminDashboard.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {

                // Fechando o modal
                var modal = document.getElementById('confirmarExclusaoModal');
                var modalBackdrop = document.querySelector('.modal-backdrop');
                if (modal && modalBackdrop) {
                    modal.style.display = 'none';
                    modalBackdrop.remove();
                }

                location.reload();
            } else {
                console.error('Erro ao excluir o usuário');
            }
        }
    };
    xhr.send('id_user=' + idUser + '&action=excluir');
});

//Fazendo uma chamada AJAX ao clicar noo botão 'Alterar Senha' e enviar o evento ao PHP
document.getElementById('form-alterar-senha').addEventListener('submit', function (event) {
    event.preventDefault(); // Previne o envio do formulário

    var idUser = document.getElementById('id_user_hidden').value;
    var novaSenha = document.getElementById('novaSenha').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'adminDashboard.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log(xhr.responseText);

                // Fechando o Modal
                var modal = document.getElementById('modalAlterarSenha');
                var bootstrapModal = new bootstrap.Modal(modal);
                bootstrapModal.hide();

                location.reload();
            } else {
                console.error('Erro ao atualizar a senha');
            }
        }
    };
    xhr.send('novaSenha=' + encodeURIComponent(novaSenha) + '&id_user=' + idUser + '&action=alterarSenha');
});

function setUserId(userId) {
    document.getElementById('id_user_hidden').value = userId;
}

document.querySelector('.exibirClientesEnderecosBtn').addEventListener('click', function () {
    // Recuperando o ID do usuário
    var userId = document.getElementById('id_user_hidden').value;
    var userType = 1; // ou qualquer outro valor desejado


    var url = "../Home/home.php?user_id=" + userId + "&user_type=" + userType;; 
    window.location.href = url;
});

document.querySelectorAll('.alterar-usuario-btn').forEach(button => {
    button.addEventListener('click', function () {
        var idUser = this.getAttribute('data-id-user');
        document.getElementById('id_user_hidden').value = idUser;
    });
});



