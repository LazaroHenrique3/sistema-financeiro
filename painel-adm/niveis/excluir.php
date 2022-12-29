<?php
require_once('../../conexao.php');

$id = @$_POST['id-excluir'];

//Verificando se o nível ja esta em uso
$query = "SELECT * FROM usuarios WHERE nivel = :id";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':id', $id);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($result);

if ($total_reg > 0) {
    echo "Este nível possuí usuário(s) associado(s) a ele, primeiro exclua o(s) respectivas usuários(s)!";
} else {
    //Deletando
    $query2 = "DELETE FROM niveis WHERE id = :id";

    $stmt = $pdo->prepare($query2);
    $stmt->bindValue(':id', $id);

    $stmt->execute();

    echo "Excluído com Sucesso!";
}
