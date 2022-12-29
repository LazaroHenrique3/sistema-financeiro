<?php
require_once('../../conexao.php');
require_once("campos.php");

echo <<<HTML
<table id="example" class="table table-light table-striped table-hover my-4" style="width:100%">
<thead>
    <tr>
        <th>{$campo1}</th>
        <th>Ações</th>
    </tr>
</thead>
<tbody>
HTML;

$query = "SELECT * FROM categorias ORDER BY id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();

//Array retornado
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < @count($result); $i++) {
    foreach ($result[$i] as $key => $value) { }

    $id = $result[$i]['id'];
    $cp1 = $result[$i]['nome'];

    echo <<<HTML
    <tr>
    <td>{$cp1}</td>
    <td>
    <a href="#" onclick="editar('{$id}', '{$cp1}')" title="Editar Registro">
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

    function editar(id, nome, email, nivel){
        $('#id').val(id);
        $('#<?=$campo1?>').val(nome);
        $('#tituloModal').text('Editar Registro');
        $('#mensagem').text('');
        var myModal = new bootstrap.Modal(document.getElementById('modalForm'),{
        });
        myModal.show();
    }

    function limparCampos(){
        $('#id').val('');
        $('#<?=$campo1?>').val('');
    }
</script>
