<?php
require_once("conexao.php");

//Verificando se há a necessidade de criar um nivel Default
$query2 = "SELECT * FROM niveis WHERE nivel = 'Root'";

$stmt2 = $pdo->prepare($query2);
$stmt2->execute();

//Array retornado
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($result2);

if ($total_reg2 == 0) {
    //Criar usuario Nível caso ele não exista
    $query2 = "INSERT INTO niveis SET nivel = :nivel";

    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindValue(':nivel', 'Root');

    $stmt2->execute();
}

//Verficando se o usuário Root já está cadastrado
$query = "SELECT * FROM usuarios AS u WHERE u.nivel IN (SELECT id FROM niveis WHERE nivel = 'Root')";

$stmt = $pdo->prepare($query);
$stmt->execute();

//Array retornado
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($result);

//Pegando id do nivel Administrador
$query3 = "SELECT id FROM niveis WHERE nivel = 'Root'";

$stmt3 = $pdo->prepare($query3);
$stmt3->execute();

$idAdmin = $stmt3->fetchAll(PDO::FETCH_ASSOC);

//Verificando se há necessidade de criar mais um root
if ($total_reg == 0) {
    //Criar usuario root caso ele não exista
    $query = "INSERT INTO usuarios SET nome = :nome, email = :email, senha = :senha, nivel = :nivel";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':nome', $nome_adm);
    $stmt->bindValue(':email', $email_adm);
    $stmt->bindValue(':senha', '123456');
    $stmt->bindValue(':nivel', $idAdmin);

    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title><?= $nome_sistema ?></title>
</head>

<body class="bg-light">


    <div class="container">
        <div class="row">
            <div class="">
                <div class="account-wall">
                    <img class="profile-img" src="img/logo.png" alt="logo">
                    <form class="form-signin" method="POST" action="autenticar.php">
                        <input name="email" type="email" class="form-control mb-2" placeholder="Email" required autofocus>
                        <input name="senha" type="password" class="form-control" placeholder="Senha" required>
                        <div class="d-grid gap-2 mt-2">
                            <button class="btn btn-primary" type="submit">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>