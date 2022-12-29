<?php
require_once('../../conexao.php');

$idVenda = @$_POST['id-venda'];

$query = "SELECT 
            p.id AS id, vp.quantidade AS quant, p.nome AS nome, vp.valorunitario AS valor
            FROM vendaprodutos AS vp
            JOIN produtos AS p
            ON vp.id_produto = p.id
            WHERE id_venda = :id";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':id', $idVenda);

$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(
   $result
);
?>


 