var controleCampo = 1;

function adicionarCampo() {
  controleCampo++;

  var novoCampo = document.createElement("div");
  novoCampo.classList.add("form-group", "campoEndereco");
  novoCampo.innerHTML =
    '<hr><div class="row"><div class="col-md-6 mt-4 mb-3"> <label class="form-label" for="cep">CEP: </label> <input type="text" class="form-control" name="cep[]" id="cep" placeholder="CEP" aria-describedby="cep" required /></div><div class="col-md-6 mt-4 mb-3"> <label>Rua: </label> <input type="text" class="form-control" aria-describedby="rua" name="rua[]" id="rua" placeholder="Rua" /></div></div> <div class="row"><div class="col-md-6 mt-4 mb-3"> <label>Número: </label><input type="number" class="form-control" aria-describedby="numero" name="numero[]" id="numero" placeholder="Número" /></div><div class="col-md-6 mt-4 mb-3"><label>Bairro: </label> <input type="text" class="form-control" aria-describedby="bairro" name="bairro[]" id="bairro" placeholder="Bairro" /></div></div> <div class="row"> <div class="col-md-6 mt-4 mb-3"> <label>Estado: </label>  <input type="text" class="form-control" aria-describedby="estado" name="estado[]" id="estado" placeholder="Estado" /> </div> <div class="col-md-6 mt-4 mb-3"><label>Cidade: </label><input type="text" class="form-control" aria-describedby="cidade" required name="cidade[]" id="cidade" placeholder="Cidade" /></div></div><button type="button" class="btn btn-outline-danger" onclick="removerCampo(this)"> Remover endereço</button></div>';

  // Adicionando os novos campos ao contêiner 'novosEnderecos'
  document.getElementById("novosEnderecos").appendChild(novoCampo);
}

function removerCampo(botao) {
    var id = botao.getAttribute("data-id");
    var campoEndereco = document.querySelector('[data-id="' + id + '"]');

    if (campoEndereco) {
        campoEndereco = campoEndereco.closest(".form-group");
        campoEndereco.style.display = "none";
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "deleteAddress.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            console.log(xhr.responseText);
            console.log("ID do Endereço: ", id);

            if (xhr.status == 200) {
                // Adicionando a classe 'removido' ao campo a ser removido
                if (campoEndereco) {
                    campoEndereco.classList.add("removido");
                }

                // Ocultando o grupo de formulário
                if (campoEndereco) {
                    campoEndereco.style.display = "none";
                }

                // Recarregando a página após a remoção
                location.reload();
            } else {
                console.error("Erro na requisição ao servidor.");
            }
        }
    };

    var data = "id_address=" + encodeURIComponent(id);
    xhr.send(data);
}
