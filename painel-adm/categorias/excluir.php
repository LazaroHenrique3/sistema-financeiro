<?php
require_once('../../conexao.php');

$id = @$_POST['id-excluir'];

//Verificando se a categoria ja esta em uso
$query = "SELECT * FROM produtos WHERE categoria = :id";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':id', $id);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($result);

if ($total_reg > 0) {
    echo "Esta categoria possuí produto(s) associado(s) a ela, primeiro exclua o(s) respectivos produtos(s)!";
} else {
     //Deletando
     $query = "DELETE FROM categorias WHERE id = :id";

     $stmt = $pdo->prepare($query);
     $stmt->bindValue(':id', $id);
 
     $stmt->execute();
 
     echo "Excluído com Sucesso!";
}
