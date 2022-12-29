<?php
require_once('../../conexao.php');
require_once("campos.php");

$cp1 = trim($_POST[$campo1]);
$cp2 = trim($_POST[$campo2]);
$cp3 = trim($_POST[$campo3]);
$cp4 = trim($_POST[$campo4]);
$cp5 = trim($_POST[$campo5]);

$id = @$_POST['id'];

//Consultando duplicação de nivel
$query = "SELECT * FROM produtos WHERE nome = :nome";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':nome', $cp2);

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
    $query = "INSERT INTO produtos SET nome = :nome, categoria = :categoria, marca = :marca, valor = :valor, descricao = :descricao";
} else {
    $query = "UPDATE produtos SET nome = :nome, categoria = :categoria, marca = :marca, valor = :valor, descricao = :descricao WHERE id = '{$id}'";
}

$stmt = $pdo->prepare($query);
$stmt->bindValue(':nome', $cp1);
$stmt->bindValue(':categoria', $cp2);
$stmt->bindValue(':valor', $cp3);
$stmt->bindValue(':descricao', $cp4);
$stmt->bindValue(':marca', $cp5);

$stmt->execute();

echo "Salvo com Sucesso!";
?>
