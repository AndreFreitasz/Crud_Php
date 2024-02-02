var controleCampo = 1;

function adicionarCampo() {
    controleCampo++;

    var novoCampo = document.createElement('div');
    novoCampo.classList.add('form-group', 'campoEndereco');
    novoCampo.innerHTML = '<hr><div class="row"><div class="col-md-6 mt-4 mb-3"> <label class="form-label" for="cep">CEP: </label> <input type="text" class="form-control" name="cep[]" id="cep" placeholder="CEP" aria-describedby="cep" required /></div><div class="col-md-6 mt-4 mb-3"> <label>Rua: </label> <input type="text" class="form-control" aria-describedby="rua" name="rua[]" id="rua" placeholder="Rua" /></div></div> <div class="row"><div class="col-md-6 mt-4 mb-3"> <label>Número: </label><input type="number" class="form-control" aria-describedby="numero" name="numero[]" id="numero" placeholder="Número" /></div><div class="col-md-6 mt-4 mb-3"><label>Bairro: </label> <input type="text" class="form-control" aria-describedby="bairro" name="bairro[]" id="bairro" placeholder="Bairro" /></div></div> <div class="row"> <div class="col-md-6 mt-4 mb-3"> <label>Estado: </label>  <input type="text" class="form-control" aria-describedby="estado" name="estado[]" id="estado" placeholder="Estado" /> </div> <div class="col-md-6 mt-4 mb-3"><label>Cidade: </label><input type="text" class="form-control" aria-describedby="cidade" required name="cidade[]" id="cidade" placeholder="Cidade" /></div></div><button type="button" class="btn btn-outline-danger" onclick="removerCampo(this)"> Remover endereço</button></div>';

    document.getElementById('enderecos').appendChild(novoCampo);
}

function removerCampo(botao) {
    var campoRemover = botao.parentNode;

    if (campoRemover) {
        campoRemover.parentNode.removeChild(campoRemover);
    } else {
        console.error('Elemento pai não encontrado. Não foi possível remover o endereço.');
    }
}