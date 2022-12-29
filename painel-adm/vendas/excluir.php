<?php
require_once('../../conexao.php');

$id = @$_POST['id-excluir'];

//Deletando os produtos daquela venda
$query = "DELETE FROM vendaprodutos WHERE id_venda = :id";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':id', $id);

$stmt->execute();

//Deletando a venda de fato
$query = "DELETE FROM venda WHERE id = :id";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':id', $id);

$stmt->execute();

echo "Excluído com Sucesso!";
?>
