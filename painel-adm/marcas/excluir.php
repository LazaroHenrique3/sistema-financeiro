<?php
require_once('../../conexao.php');

$id = @$_POST['id-excluir'];

//Verificando se a marca já esta em uso
$query = "SELECT * FROM produtos WHERE marca = :id";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':id', $id);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($result);

if ($total_reg > 0) {
    echo "Esta marca possuí produto(s) associado(s) a ela, primeiro exclua o(s) respectivos produtos(s)!";
} else {
    //Deletando
    $query = "DELETE FROM marcas WHERE id = :id";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', $id);

    $stmt->execute();

    echo "Excluído com Sucesso!";
}
