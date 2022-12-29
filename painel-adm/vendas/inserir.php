<?php
require_once('../../conexao.php');
require_once("../utilidades.php");
require_once("campos.php");

$cp1 = trim($_POST[$campo1]);
$cp2 = trim($_POST[$campo3]);
$cp3 = trim($_POST[$campo5]);

$id = @$_POST['id'];
$produtos = json_decode($_POST['lista-produtos'], true);

if ($id == "") {

    //Cadastrando a venda
    $query = "INSERT 
                INTO venda SET
                     status = :status, 
                     id_cliente = :id_cliente, 
                     forma_pagamento = :forma_pagamento, 
                     total = :total";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':status', 1);
    $stmt->bindValue(':id_cliente', $cp1);
    $stmt->bindValue(':forma_pagamento', $cp2);
    $stmt->bindValue(':total', formataValorBanco($cp3));

    $stmt->execute();

    //Pegar o ID do último produto que foi cadastrado
    $query = "SELECT LAST_INSERT_ID();";

    //Executando a sql para pegar a ID do produto que acabou de ser cadastrado
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $idVenda = $result["LAST_INSERT_ID()"];

    //Cadastrando os produtos da venda e dando baixa no estoque
    foreach ($produtos as $key => $value) {

        $query = "INSERT 
                    INTO vendaprodutos SET 
                         id_venda = :id_venda, 
                         id_produto = :id_produto, 
                         quantidade = :quantidade, 
                         valorunitario = :valorunitario";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id_venda', $idVenda);
        $stmt->bindValue(':id_produto', $value['id']);
        $stmt->bindValue(':quantidade', $value['quant']);
        $stmt->bindValue(':valorunitario', formataValorBanco($value['valor']));

        $stmt->execute();
    }

} else {
    
    $query = "UPDATE venda SET
                status = :status, 
                id_cliente = :id_cliente, 
                forma_pagamento = :forma_pagamento, 
                total = :total
                WHERE id = '{$id}'";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':status', 1);
    $stmt->bindValue(':id_cliente', $cp1);
    $stmt->bindValue(':forma_pagamento', $cp2);
    $stmt->bindValue(':total', formataValorBanco($cp3));

    $stmt->execute();

    //Deletando os produtos antigos da venda e cadastrando os novos
    $query = $pdo->query("DELETE FROM vendaprodutos WHERE id_venda = {$id}");

    //Atualizado os produtos da venda
    foreach ($produtos as $key => $value) {

        //Cadastrando os novos produtos
        $query = "INSERT 
                    INTO vendaprodutos SET 
                    id_venda = :id_venda, 
                    id_produto = :id_produto, 
                    quantidade = :quantidade, 
                    valorunitario = :valorunitario";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id_venda', $id);
        $stmt->bindValue(':id_produto', $value['id']);
        $stmt->bindValue(':quantidade', $value['quant']);
        $stmt->bindValue(':valorunitario', formataValorBanco($value['valor']));

        $stmt->execute();
    }
}

echo "Salvo com Sucesso!";
