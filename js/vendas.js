//Select2
$(".js-example-responsive").select2({
    width: 'resolve'
});

$('.select').select2({
    dropdownParent: $('#modalForm')
});

pag = "vendas";

vendaCampo1 = $('#Cliente');
vendaCampo2 = $('#FormaPagamento');

arrayProdutos = [];

//Variaveis 
produto = undefined;
quant = 0;

function editar(id, cliente, pagamento) {
    $('#id').val(id);
    $('#Cliente').val(cliente.toString());
    $('#Cliente').trigger('change');
    $('#FormaPagamento').val(pagamento);
    $('#tituloModal').text('Editar Registro');
    $('#mensagem').text('')

    //Povoando a tabela
    verProdutos(id, 'editar')

    var myModal = new bootstrap.Modal(document.getElementById('modalForm'), {});
    myModal.show();
}

function limparCampos() {
    $('#id').val('');

    $('#text-Cliente').removeClass('text-danger').html('');
    $('#Cliente').val('selecione');
    $('#Cliente').trigger('change');

    $('#text-produto').removeClass('text-danger').html('');
    $('#Produto').val('selecione');
    $('#Produto').trigger('change');

    $('#qtdProdutos').val('');
    $('#alert-quant').removeClass('text-danger').html('');

    $('#tabela-produtos').html("");

    $('#text-FormaPagamento').removeClass('text-danger').html('');
    $('#FormaPagamento').removeClass('border-danger').val('selecione');

    $('#Total').val('0');
    arrayProdutos = [];
}

function validaInputs(inputs) {

    let status = true;

    //verificando se existe produtos no objeto
    if (JSON.stringify(arrayProdutos) == "[]") {
        $('#Produto').addClass('border-danger')
        $('#text-produto').addClass('text-danger').html('Adicione produtos a venda!')
        status = false;
    } else {
        $('#Produto').removeClass('border-danger')
        $('#text-produto').removeClass('text-danger').html('')
    }

    inputs.forEach(element => {
        if (element.attr('id') == 'Cliente') {
            if (element.val() == null) {
                element.removeClass('border-success').addClass('border border-danger');
                $('#text-Cliente').removeClass('text-success').addClass('text-danger').html("Escolha uma opção!");
                status = false;
            } else {
                element.removeClass('border-danger');
                $('#text-Cliente').removeClass('text-danger').html("");
            }

        } else if (element.attr('id') == 'FormaPagamento') {
            if (element.val() == null) {
                element.removeClass('border-success').addClass('border border-danger');
                $('#text-FormaPagamento').removeClass('text-success').addClass('text-danger').html("Escolha uma opção!");
                status = false;
            } else {
                element.removeClass('border-danger');
                $('#text-FormaPagamento').removeClass('text-danger').html("");
            }
        }
    });

    return status;
}

function adicionarProduto() {

    let campos = validaCampos();

    if (campos) {
        //Pegando o id do produto
        let idProduto = $('#Produto').val();

        //Pegando a quantidade de produtos
        let quantProduto =  $('#qtdProdutos').val();

        //Buscando as informações do produto
        infoProduto(idProduto);

        //Verificando se esse produto já não foi adicionado ao array
        if (arrayProdutos.find(prod => prod.nome === produto.nome) != undefined) {
            //Significa que já foi adcionado
            $('#Produto').addClass('border-danger');
            $('#text-produto').addClass('text-danger').html('Este produto já foi adicionado!');
        } else {
            //Significa que ainda não foi adcionado
            $('#Produto').removeClass('border-danger');
            $('#text-produto').removeClass('text-danger').html('');

            //Formatando o valor
            let valorUnitario = parseFloat(produto.valor);
            /*
            valorUnitario = valorUnitario.toLocaleString('pt-br', {
                minimumFractionDigits: 2
            });
            */

            //Adicionando o produto no Array
            let p = {
                id: produto.id,
                nome: produto.nome,
                quant: quantProduto,
                valor: valorUnitario
            };

            arrayProdutos.push(p);
            adicionarProdutoTabela(arrayProdutos);
        }
    }
}

function adicionarProdutoTabela(produtos) {
    let totalSoma = 0;
    let linhaTabela = '';

    //Verificando se já é o último elemento
    let size = Object.keys(arrayProdutos).length;
    if (size == 0) {
        $('#tabela-produtos').html('');
    } else {
        produtos.forEach(element => {
            let valorTotalProduto = parseFloat(element.quant) * parseFloat(element.valor);
            let valorUnitario = parseFloat(element.valor);
            linhaTabela += `
        <tr>
            <td>${element.nome}</td>
            <td>${element.quant}</td>
            <td>${valorUnitario.toLocaleString('pt-br', { minimumFractionDigits: 2 })}</td>
            <td>${valorTotalProduto.toLocaleString('pt-br', { minimumFractionDigits: 2 })}</td>
            <td>
                <a href="#" onclick="removerProduto(${element.id})" title="Remover Produto">
                    <i class="bi bi-trash text-danger"></i>
                </a>
            </td>
        </tr>`;

            $('#tabela-produtos').html(linhaTabela);

            totalSoma += valorTotalProduto;
        });
    }
    $('#lista-produtos').val();
    atualizaTotal(totalSoma);
}

function atualizaTotal(total) {
    $('#Total').val(total.toLocaleString('pt-br', {
        minimumFractionDigits: 2
    }));
}

function removerProduto(idProduto) {
    var result = arrayProdutos.filter(function (el) {
        return el.id == idProduto;
    });

    for (var elemento of result) {
        var index = arrayProdutos.indexOf(elemento);
        arrayProdutos.splice(index, 1);
    }

    //Atualizando a tabela e o valor
    adicionarProdutoTabela(arrayProdutos);
}

function validaCampos() {
    let camposValidados = true;

    let produtoInput = $('#Produto').val();
    let quantProdInput = $('#qtdProdutos').val();

    //Verificando o campo de produto
    if (produtoInput == '' || produtoInput == null) {
        $('#Produto').addClass('border-danger');
        camposValidados = false;
    } else {
        $('#Produto').removeClass('border-danger');
    }

    //Verificandoo campo de quantidade
    if (quantProdInput == 0 || quantProdInput == null) {
        $('#qtdProdutos').addClass('border-danger');
        camposValidados = false;
    } else {
        $('#qtdProdutos').removeClass('border-danger');
    }


    return camposValidados;
}

//Essa função vai atualizar  a variavel global onde será armazenado a sinformaçoes do produto
function infoProduto(id) {

    var formData = new FormData();
    formData.append('id-produto', id);

    $.ajax({
        url: pag + "/buscar-produto.php",
        async: false,
        type: 'POST',
        data: formData,

        success: function (result) {
            produto = JSON.parse(result);
        },

        cache: false,
        contentType: false,
        processData: false,

    });

}