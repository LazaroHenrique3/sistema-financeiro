<?php
require_once('../../conexao.php');
require_once("../utilidades.php");
require_once("campos.php");

$cp1 = trim($_POST[$campo1]);
$cp2 = apenasNumeros(trim($_POST[$campo2]));
$cp3 = trim($_POST[$campo3]);
$cp4 = trim($_POST[$campo4]);

$id = @$_POST['id'];

//Verificando se o cpf é válido
if(!validaCPF($cp2)){
    echo 'CPF Inválido!';
    exit();
}

//Consultando duplicação de cpf
$query = "SELECT * FROM clientes WHERE cpf = :cpf";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':cpf', $cp2);

$stmt->execute();

//Array retornado
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($result);
$id_reg = @$result[0]['id'];

if($total_reg > 0 && $id_reg != $id){
    echo 'Este CPF já foi cadastrado!';
    exit();
}

if($id == ""){
    $query = "INSERT INTO clientes SET nome = :nome, cpf = :cpf, telefone = :telefone, observacao = :observacao";
} else {
    $query = "UPDATE clientes SET nome = :nome, cpf = :cpf, telefone = :telefone, observacao = :observacao WHERE id = '{$id}'";
}

$stmt = $pdo->prepare($query);
$stmt->bindValue(':nome', $cp1);
$stmt->bindValue(':cpf', apenasNumeros($cp2));
$stmt->bindValue(':telefone', apenasNumeros($cp3));
$stmt->bindValue(':observacao', $cp4);

$stmt->execute();

echo "Salvo com Sucesso!";
