<?php
require_once('../../conexao.php');

$idProduto = $_POST['id-produto'];

if(isset($_POST['id-produto'])){

    $query = "SELECT id, nome, valor FROM produtos WHERE id = {$idProduto}";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode(array(
        'id' => $result['id'],
        'nome' => $result['nome'],
        'valor' => $result['valor']
    ));
}

?>


