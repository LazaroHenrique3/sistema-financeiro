<?php
require_once('../../conexao.php');
require_once("campos.php");

$cp1 = trim($_POST[$campo1]);

$id = @$_POST['id'];

//Consultando duplicação de nivel
$query = "SELECT * FROM niveis WHERE nivel = :nivel";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':nivel', $cp1);

$stmt->execute();

//Array retornado
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($result);
$id_reg = @$result[0]['id'];

if($total_reg > 0 && $id_reg != $id){
    echo 'Este nível já foi cadastrado!';
    exit();
}

if($id == ""){
    $query = "INSERT INTO niveis SET nivel = :nivel";
} else {
    $query = "UPDATE niveis SET nivel = :nivel WHERE id = '{$id}'";
}

$stmt = $pdo->prepare($query);
$stmt->bindValue(':nivel', $cp1);
$stmt->execute();

echo "Salvo com Sucesso!";
?>
