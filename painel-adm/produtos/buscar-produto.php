<?php
require_once('../../conexao.php');

$idProduto = @$_POST['id-produto'];

$query = "SELECT nome, valor FROM produtos WHERE id = :id";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':id', $idProduto);

$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(array(
    'nome' => $result['nome'],
    'valor' => $result['valor']
));


?>


