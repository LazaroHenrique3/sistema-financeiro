<?php
require_once('../conexao.php');

$nome = trim($_POST['nome-usuario']);
$email = trim($_POST['email-usuario']);
$senha = password_hash(trim($_POST['senha-usuario']), PASSWORD_DEFAULT);
$id = $_POST['id-usuario'];

//Consultando duplicação de email
$query = "SELECT * FROM usuarios WHERE email = :email";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':email', $email);

$stmt->execute();

//Array retornado
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($result);
$id_usu = $result[0]['id'];

if($total_reg > 0 && $id_usu != $id){
    echo 'Este email já foi cadastrado!';
    exit();
}

//Verificando se foi passado senha para alteração
if($senha != ""){
    $query = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = {$id}";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':senha', $senha);
} else {
    $query = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = {$id}";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':email', $email);
}

$stmt->execute();

echo "Salvo com Sucesso!";
?>

