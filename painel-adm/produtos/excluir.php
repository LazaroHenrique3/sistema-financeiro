<?php
require_once('../../conexao.php');

$id = @$_POST['id-excluir'];

//Verificando see o produto já está em alguma venda
$query = "SELECT *  FROM vendaprodutos WHERE id_produto = :id";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':id', $id);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($result);

if ($total_reg > 0) {
    echo "Este produto possuí venda(s) associados a ele, primeiro exclua a(s) respectivas venda(s)!";
} else {
    //Deletando
    $query = "DELETE FROM produtos WHERE id = :id";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', $id);

    $stmt->execute();

    echo "Excluído com Sucesso!";
}
