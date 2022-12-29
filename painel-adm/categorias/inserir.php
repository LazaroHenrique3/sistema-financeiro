<?php
require_once('../../conexao.php');
require_once("campos.php");

$cp1 = trim($_POST[$campo1]);

$id = @$_POST['id'];

//Consultando duplicação de nivel
$query = "SELECT * FROM categorias WHERE nome = :nome";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':nome', $cp1);

$stmt->execute();

//Array retornado
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($result);
$id_reg = @$result[0]['id'];

if($total_reg > 0 && $id_reg != $id){
    echo 'Este registro já foi cadastrado!';
    exit();
}

if($id == ""){
    $query = "INSERT INTO categorias SET nome = :nome";
} else {
    $query = "UPDATE categorias SET nome = :nome WHERE id = '{$id}'";
}

$stmt = $pdo->prepare($query);
$stmt->bindValue(':nome', $cp1);

$stmt->execute();

echo "Salvo com Sucesso!";
?>
