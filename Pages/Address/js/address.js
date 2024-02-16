var controleCampo = 1;

function adicionarCampo() {
    var controleCampoAtual = controleCampo;
    controleCampo++;

    var novoCampo = document.createElement("div");
    novoCampo.classList.add("form-group", "campoEndereco");
    novoCampo.innerHTML =
        '<div class="row"><div class="col-md-6 mt-4 mb-3"> <label class="form-label" for="cep">CEP: </label> <input type="text" class="form-control" name="cep[]" id="cep_' + controleCampoAtual + '" placeholder="CEP" aria-describedby="cep" required /></div><div class="col-md-6 mt-4 mb-3"> <label>Rua: </label> <input type="text" class="form-control" aria-describedby="rua" name="rua[]" id="rua_' + controleCampoAtual + '" placeholder="Rua" required/></div></div> <div class="row"><div class="col-md-6 mt-4 mb-3"> <label>Número: </label><input type="number" class="form-control" aria-describedby="numero" name="numero[]" id="numero_' + controleCampoAtual + '" placeholder="Número" required/></div><div class="col-md-6 mt-4 mb-3"><label>Bairro: </label> <input type="text" class="form-control" aria-describedby="bairro" name="bairro[]" id="bairro_' + controleCampoAtual + '" placeholder="Bairro" required/></div></div> <div class="row"> <div class="col-md-6 mt-4 mb-3"> <label>Estado: </label>  <input type="text" class="form-control" aria-describedby="estado" name="estado[]" id="estado_' + controleCampoAtual + '" placeholder="Estado" required/> </div> <div class="col-md-6 mt-4 mb-3"><label>Cidade: </label><input type="text" class="form-control" aria-describedby="cidade" required name="cidade[]" id="cidade_' + controleCampoAtual + '" placeholder="Cidade" required/></div></div><button type="button" class="btn btn-outline-danger" onclick="removerCampo(this)"> Remover endereço</button></div><hr>';

    document.getElementById("novosEnderecos").appendChild(novoCampo);

    var inputmask = new Inputmask('99999-999');
    inputmask.mask(document.getElementById("cep_" + controleCampoAtual));

    // Verificando se é o primeiro endereço adicionado
    var mainAddress = document.querySelectorAll('[name="main_address[]"]').length === 0 ? 1 : 0;

    // Adicionando o valor de main_address[] ao novo campo
    var mainAddressInput = document.createElement("input");
    mainAddressInput.type = "hidden";
    mainAddressInput.name = "main_address[]";
    mainAddressInput.value = mainAddress;
    novoCampo.appendChild(mainAddressInput);

    // Acrescentando evento de blur para buscar o endereço ao preencher o CEP
    document.getElementById("cep_" + controleCampoAtual).addEventListener("blur", function (controleCampoAtual) {
        return function () {
            var cep = this.value.replace(/\D/g, '');
            if (cep.length != 8) {
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "https://viacep.com.br/ws/" + cep + "/json/", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    if (!data.erro) {
                        document.getElementById("rua_" + controleCampoAtual).value = data.logradouro;
                        document.getElementById("bairro_" + controleCampoAtual).value = data.bairro;
                        document.getElementById("cidade_" + controleCampoAtual).value = data.localidade;
                        document.getElementById("estado_" + controleCampoAtual).value = data.uf;
                    }
                }
            };
            xhr.send();
        };
    }(controleCampoAtual));
}

var enderecosRemovidos = []; // Declare e inicialize a variável globalmente


function removerCampo(botao) {
    var grupoCampos = botao.closest(".form-group");

    if (grupoCampos) {
        grupoCampos.style.display = "none";

        // Encontra o input hidden com o ID do endereço dentro do grupo de campos
        var idInput = grupoCampos.querySelector('[name="id_address[]"]');
        grupoCampos.querySelectorAll('input[type="text"], input[type="number"]').forEach(function (field) {
            field.disabled = true;
        });

        if (idInput) {
            var id = idInput.value;

            // Remove o ID do endereço do array enderecosRemovidos
            var index = enderecosRemovidos.indexOf(id);
            if (index !== -1) {
                enderecosRemovidos.splice(index, 1);
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "deleteAddress.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    console.log(xhr.responseText);

                    if (xhr.status == 200) {
                        // Verificando se há um registro no banco de dados para o ID do endereço
                        var response = JSON.parse(xhr.responseText);
                        if (response.hasRecord) {
                            console.log("Registro encontrado. Endereço excluído.");
                        }
                        // Recarregar a página após a exclusão
                        location.reload();
                    } else {
                        console.error("Erro na requisição ao servidor.");
                    }
                }
            };

            var data = "id_address=" + encodeURIComponent(id);
            xhr.send(data);
        } else {
            console.error("ID do endereço não encontrado.");
        }
    } else {
        console.error("Grupo de campos não encontrado.");
    }
}
