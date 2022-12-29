<?php
require_once('../../conexao.php');

$id = @$_POST['id-excluir'];

//Deletando
$query = "DELETE FROM usuarios WHERE id = :id";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':id', $id);

$stmt->execute();

echo "Excluído com Sucesso!";
?>
