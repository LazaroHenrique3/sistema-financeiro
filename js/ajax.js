$(document).ready(function () {
    listar();
});

$("#form").submit(function () {
    //Para não atualizar a página
    event.preventDefault();

    var formData = new FormData(this);

    if (pag == 'vendas') {
        //Inputs a serem validados
        let inputs = new Array();
        inputs.push(vendaCampo1);
        inputs.push(vendaCampo2);


        if (validaInputs(inputs)) {
            cadastrar(formData, 'vendas');
        }

    } else {
        cadastrar(formData);
    }
});

function cadastrar(formData, tipo = '') {

    if (tipo == 'vendas') {
        //criando o Json do objeto de produtos
        let jsonProdutos = JSON.stringify(arrayProdutos);

        formData.append('lista-produtos', jsonProdutos);
    }

    $.ajax({
        url: pag + "/inserir.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso!") {
                $('#btn-fechar').click();
                listar();
            } else {
                $('#mensagem').addClass('text-danger')
            }

            $('#mensagem').text(mensagem)
        },

        cache: false,
        contentType: false,
        processData: false,

    });
}

function listar() {
    $.ajax({
        url: pag + "/listar.php",
        method: 'POST',
        data: $('#form').serialize(),
        dataType: "html",

        success: function (result) {
            $("#listar").html(result);
        }
    });
}

function excluir(id, nome) {
    $('#id-excluir').val(id);
    $('#nome-excluido').text(nome);
    var myModal = new bootstrap.Modal(document.getElementById('modalExcluir'), {
    });
    myModal.show();
    $('#mensagem-excluir').text('');
    $('#mensagem-excluir').removeClass();
}

function inserir() {
    $('#tituloModal').text('Inserir Registro');
    $('#mensagem').text('');
    $("#Senha").attr("required", "req");
    var myModal = new bootstrap.Modal(document.getElementById('modalForm'), {
    });
    myModal.show();
    limparCampos();
}

$("#form-excluir").submit(function () {
    //Para não atualizar a página
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/excluir.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {

            $('#mensagem-excluir').text('');
            $('#mensagem-excluir').removeClass();
            if (mensagem.trim() == "Excluído com Sucesso!") {
                $('#btn-fechar-excluir').click();
                listar();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
            }

            $('#mensagem-excluir').text(mensagem)
        },

        cache: false,
        contentType: false,
        processData: false,

    });
});



