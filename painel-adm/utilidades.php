<?php

function formataCPF($cpf)
{
    return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
}

function formataTelefone($telefone)
{
    return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 3, 1) . ' ' . substr($telefone, 3, 4) . '-' . substr($telefone, 7, 10);
}

function formataCep($cep)
{
    return substr($cep, 0, 5) . '-' . substr($cep, 5, 8);
}

function formataData($data)
{
    return implode("/", array_reverse(explode("-", $data)));
}

function formataDataHora($data)
{
    return date('d/m/Y H:i:s', strtotime($data));
}

function apenasNumeros($str)
{
    $string = $str;

    //Remove o espaço
    $string = str_replace(' ', '', $string);
    //Remove o traço
    $string = str_replace('-', '', $string);
    //Remove o ponto
    $string = str_replace('.', '', $string);
    //A abertura de parenteses
    $string = str_replace('(', '', $string);
    //O fechamento de parenteses
    $string = str_replace(')', '', $string);

    return $string;
}

function formataValor($valor)
{

    $valor = str_replace('.', ',', $valor);
    $strValor = "R$ " . $valor;

    return $strValor;
}

function formataValorBanco($valor)
{
    //Removendo o ponto e trocando a virgula dos centavos por (.)

    if(strpos($valor, ',')){
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
    } else {
        $valor = str_replace(',', '.', $valor);
    }
   
    return $valor;
}

function validaCPF($cpf)
{

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

function formataFormaPagamaneto($formaPagamento)
{

    switch ($formaPagamento) {
        case 1:
            return "Dinheiro";
            break;

        case 2:
            return "PIX";
            break;

        case 3:
            return "Boleto";
            break;

        case 4:
            return "C. Crédito";
            break;

        case 5:
            return "C. Débito";
            break;

        default:
            return "Indefinido";
            break;
    }
}

function formataStatus($status)
{

    switch ($status) {
        case 1:
            return "Concluído";
            break;

        case 2:
            return "Pendente";
            break;

        default:
            return "Indefinido";
            break;
    }
}
