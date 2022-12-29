<?php
@session_start();
require_once("conexao.php");

//addslashes troca caracteres especiais por \
$email = addslashes(trim($_POST['email']));
$senha = addslashes(trim($_POST['senha']));

//Consultando a existencia do usuario no banco
$query = "SELECT u.id, u.senha, u.nivel, u.nome, n.nivel AS nomeNivel
             FROM usuarios AS u
             JOIN niveis AS n
             ON u.nivel = n.id
             WHERE u.email = :email";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':email', $email);

$stmt->execute();

//Array retornado
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Verificando o total de retornos
if($result['id'] != '' && password_verify($senha, $result['senha']) ){

    //$nivel = $result['nivel'];

    //Variavel de sessão
    $_SESSION['nivel_usuario'] = $result['nomeNivel'];
    $_SESSION['id_usuario'] = $result['id'];
    $_SESSION['nome_usuario'] = $result['nome'];

    //Talvez futuramente eu implemente esse controle de painel
    /*if($nivel == 'Administrador'){
        echo "<script>window.location='painel-adm'</script>";
    }*/

    //Redireionando para o painel administrativo usando Javascript
    echo "<script>window.location='painel-adm'</script>";
} else {
    echo "<script>window.alert('Dados Incorretos!')</script>";
    echo "<script>window.location='index.php'</script>";
}
?>