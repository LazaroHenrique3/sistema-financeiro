<?php
require_once('../../conexao.php');
require_once("../utilidades.php");
require_once("campos.php");

echo <<<HTML
<table id="example" class="table table-light table-striped table-hover my-4" style="width:100%">
<thead>
    <tr>
        <th>{$campo4}</th>
        <th>{$campo1}</th>
        <th>{$campo2}</th>
        <th>Pagamento</th>
        <th>{$campo5}</th>
        <th>Data/Hora</th>
        <th>Ações</th>
    </tr>
</thead>
<tbody>
HTML;

$query = "SELECT
             v.id, v.status, v.id_cliente AS cliente, c.nome AS nomeCliente, v.forma_pagamento, v.total, v.datacadastro
             FROM venda AS v  
             JOIN clientes AS c
             ON v.id_cliente = c.id
             ORDER BY v.id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();

//Array retornado
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < @count($result); $i++) {
    foreach ($result[$i] as $key => $value) {
    }

    $id = $result[$i]['id'];
    $cp1 = $result[$i]['status'];
    $cp2 = $result[$i]['nomeCliente'];
    $cp3 = $result[$i]['forma_pagamento'];
    $cp4 = $result[$i]['total'];
    $cp5 = $result[$i]['datacadastro'];

    $idCliente = $result[$i]['cliente'];

    $statusFormatado = formataStatus($cp1);
    $dataHoraFormatada = formataDataHora($cp5);
    $pagamentoFormatado = formataFormaPagamaneto($cp3);
    $valorFormatado = number_format($cp4, 2, ',', '.');

    echo <<<HTML
    <tr>
    <td>{$statusFormatado}</td>
    <td>{$cp2}</td>
    <td>
    <a href="#" onclick="verProdutos('{$id}')" title="Ver Produtos">
        <i class="bi bi-eye-fill"></i>
    </a>
    </td>
    <td>{$pagamentoFormatado}</td>
    <td>{$valorFormatado}</td>
    <td>{$dataHoraFormatada}</td>
    <td>
    <a href="#" onclick="editar('{$id}', '{$idCliente}', '{$cp3}')" title="Editar Registro">
            <i class="bi bi-pencil-square text-primary"></i>
    </a>
    <a href="#" onclick="excluir('{$id}')" title="Excluir Registro">
            <i class="bi bi-trash text-danger"></i>
    </a>
    </td>
    </tr>
    HTML;
}
echo <<<HTML
</tbody>
</table>
HTML;
?>

<script src="../js/vendas.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "ordering": false
        });
    });

    function verProdutos(id, tipo = '') {
        var formData = new FormData();
        formData.append('id-venda', id);
        $.ajax({
            url: "vendas/buscar-produto-venda.php",
            async: false,
            type: 'POST',
            data: formData,

            success: function(result) {
                produtos = JSON.parse(result);
                if(tipo == ''){
                    adicionarProdutoTabelaDetalhes(produtos)
                } else if ('editar'){
                    arrayProdutos = produtos;
                    adicionarProdutoTabela(arrayProdutos);
                }
                
            },

            cache: false,
            contentType: false,
            processData: false,

        });
    }

    function adicionarProdutoTabelaDetalhes(produtos) {
        let linhaTabela = '';

        produtos.forEach(element => {
            let valorTotalProduto = parseFloat(element.quant) * parseFloat(element.valor);
            let valorUnitario = parseFloat(element.valor);
            linhaTabela += `
            <tr>
                <td>${element.nome}</td>
                <td>${element.quant}</td>
                <td>${valorUnitario.toLocaleString('pt-br', {minimumFractionDigits: 2})}</td>
                <td>${valorTotalProduto.toLocaleString('pt-br', {minimumFractionDigits: 2})}</td>
            </tr>`;

            $('#tabela-produtos-visualizar-detalhes').html(linhaTabela);
        });

        var myModal = new bootstrap.Modal(document.getElementById('verProdutos'), {});
        myModal.show();
    }

    function adicionarProdutoTabelaEditar(produtos) {
        let linhaTabela = '';

        produtos.forEach(element => {
            let valorTotalProduto = parseFloat(element.quant) * parseFloat(element.valor);
            let valorUnitario = parseFloat(element.valor);
            linhaTabela += `
            <tr>
                <td>${element.nome}</td>
                <td>${element.quant}</td>
                <td>${valorUnitario.toLocaleString('pt-br', {minimumFractionDigits: 2})}</td>
                <td>${valorTotalProduto.toLocaleString('pt-br', {minimumFractionDigits: 2})}</td>
                <td>
                    <a href="#" onclick="removerProduto(${element.id})" title="Remover Produto">
                        <i class="bi bi-trash text-danger"></i>
                    </a>
                </td>
            </tr>`;

            $('#tabela-produtos').html(linhaTabela);
        });
    }
</script>

