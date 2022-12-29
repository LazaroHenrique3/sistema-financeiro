<?php
require_once('../../conexao.php');
require_once("campos.php");

$cp1 = trim($_POST[$campo1]);
$cp2 = trim($_POST[$campo2]);
$cp3 = trim($_POST[$campo3]);

$cp4 = password_hash(trim($_POST[$campo4]), PASSWORD_DEFAULT);

$id = @$_POST['id'];

//Consultando duplicação de nivel
$query = "SELECT * FROM usuarios WHERE email = :email";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':email', $cp2);

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
    $query = "INSERT INTO usuarios SET nome = :nome, email = :email, nivel = :nivel, senha = :senha";
} else {

    //Verificando se foi passado senha para alteração
    if(isset($_POST[$campo4]) && $_POST[$campo4] != ""){
        $query = "UPDATE usuarios SET nome = :nome, email = :email, nivel = :nivel, senha = :senha WHERE id = '{$id}'";
    } else {
        $query = "UPDATE usuarios SET nome = :nome, email = :email, nivel = :nivel WHERE id = '{$id}'";
    }
    
}

$stmt = $pdo->prepare($query);
$stmt->bindValue(':nome', $cp1);
$stmt->bindValue(':email', $cp2);
$stmt->bindValue(':nivel', $cp3);

//Verificando se foi passado senha para alteração
if(isset($_POST[$campo4]) && $_POST[$campo4] != ""){
    $stmt->bindValue(':senha', $cp4);
}

$stmt->execute();

echo "Salvo com Sucesso!";
?>
