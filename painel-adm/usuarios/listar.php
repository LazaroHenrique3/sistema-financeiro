<?php
require_once('../../conexao.php');
require_once("campos.php");

echo <<<HTML
<table id="example" class="table table-light table-striped table-hover my-4" style="width:100%">
<thead>
    <tr>
        <th>{$campo1}</th>
        <th>{$campo2}</th>
        <th>{$campo3}</th>
        <th>Ações</th>
    </tr>
</thead>
<tbody>
HTML;

$query = "SELECT 
            u.id, u.nome, u.nivel, n.nivel AS nomeNivel, u.email, u.nivel 
            FROM usuarios AS u 
            JOIN niveis AS n
            ON u.nivel = n.id
            ORDER BY id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();

//Array retornado
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < @count($result); $i++) {
    foreach ($result[$i] as $key => $value) { }
        if($result[$i]['nomeNivel'] != 'Root'){
        $id = $result[$i]['id'];
        $cp1 = $result[$i]['nome'];
        $cp2 = $result[$i]['email'];
        $cp3 = $result[$i]['nivel'];
        $nomeNivel = $result[$i]['nomeNivel'];

        echo <<<HTML
        <tr>
        <td>{$cp1}</td>
        <td>{$cp2}</td>
        <td>{$nomeNivel}</td>
        <td>
        <a href="#" onclick="editar('{$id}', '{$cp1}', '{$cp2}', '{$cp3}')" title="Editar Registro">
                <i class="bi bi-pencil-square text-primary"></i>
        </a>
        <a href="#" onclick="excluir('{$id}', '{$cp1}')" title="Excluir Registro">
                <i class="bi bi-trash text-danger"></i>
        </a>
        </td>
        </tr>
        HTML;
    }
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
        $('#<?=$campo2?>').val(email);
        $('#<?=$campo3?>').val(nivel);
        $('#<?=$campo4?>').val('');
        $('#tituloModal').text('Editar Registro');
        $('#mensagem').text('')
        //Removendo o required do campo
        $('#<?=$campo4?>').removeAttr('required');
        var myModal = new bootstrap.Modal(document.getElementById('modalForm'),{
        });
        myModal.show();
    }

    function limparCampos(){
        $('#id').val('');
        $('#<?=$campo1?>').val('');
        $('#<?=$campo2?>').val('');
    }
</script>
