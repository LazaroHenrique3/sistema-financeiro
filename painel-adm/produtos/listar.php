<?php
require_once('../../conexao.php');
require_once("campos.php");

echo <<<HTML
<table id="example" class="table table-light table-striped table-hover my-4" style="width:100%">
<thead>
    <tr>
        <th>{$campo1}</th>
        <th>{$campo2}</th>
        <th>{$campo5}</th>
        <th>{$campo3}</th>
        <th>Descrição</th>
        <th>Ações</th>
    </tr>
</thead>
<tbody>
HTML;

$query = "SELECT
             p.id, p.nome, p.categoria, p.marca, p.valor, p.descricao, c.nome AS nomeCategoria, m.nome AS nomeMarca
             FROM produtos AS p  
             JOIN categorias AS c
             ON p.categoria = c.id
             JOIN marcas AS m
             ON p.marca = m.id
             ORDER BY p.id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();

//Array retornado
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < @count($result); $i++) {
    foreach ($result[$i] as $key => $value) { }

    $id = $result[$i]['id'];
    $cp1 = $result[$i]['nome'];
    $cp2 = $result[$i]['nomeCategoria'];
    $cp3 = $result[$i]['valor'];
    $cp4 = $result[$i]['descricao'];
    $cp5 = $result[$i]['nomeMarca'];

    $idCategoria = $result[$i]['categoria'];
    $idMarca = $result[$i]['marca'];

    echo <<<HTML
    <tr>
    <td>{$cp1}</td>
    <td>{$cp2}</td>
    <td>{$cp5}</td>
    <td>{$cp3}</td>
    <td>{$cp4}</td>
    <td>
    <a href="#" onclick="editar('{$id}', '{$cp1}', '{$idCategoria}', '{$cp3}', '{$cp4}', '{$idMarca}')" title="Editar Registro">
            <i class="bi bi-pencil-square text-primary"></i>
    </a>
    <a href="#" onclick="excluir('{$id}', '{$cp1}')" title="Excluir Registro">
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

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "ordering": false
        });
    });

    function editar(id, nome, categoria, valor, descricao, marca){
        $('#id').val(id);
        $('#<?=$campo1?>').val(nome);
        $('#<?=$campo2?>').val(categoria);
        $('#<?=$campo3?>').val(valor);
        $('#<?=$campo4?>').val(descricao);
        $('#<?=$campo5?>').val(marca);
        $('#tituloModal').text('Editar Registro');
        $('#mensagem').text('')
        var myModal = new bootstrap.Modal(document.getElementById('modalForm'),{
        });
        myModal.show();
    }

    function limparCampos(){
        $('#id').val('');
        $('#<?=$campo1?>').val('');
        $('#<?=$campo2?>').val('selecione');
        $('#<?=$campo3?>').val('');
        $('#<?=$campo4?>').val('');
        $('#<?=$campo5?>').val('selecione');
    }
</script>
