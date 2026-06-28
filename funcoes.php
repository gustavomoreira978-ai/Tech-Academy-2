<?php

function calcularDesconto($preco, $porcentagem)
{
    if ($preco <= 0 || $porcentagem <= 0) {
        return $preco;
    }

    $desconto = ($preco * $porcentagem) / 100;
    return $preco - $desconto;
}

function calcularFrete($valorCompra)
{
    if ($valorCompra >= 199) {
        return 0;
    }

    return 19.90;
}

function formatarPreco($valor)
{
    return "R$ " . number_format($valor, 2, ",", ".");
}

function filtrarPromocoes($listaPromocoes, $descontoMinimo)
{
    $resultado = [];

    foreach ($listaPromocoes as $promocao) {
        if ($promocao["desconto"] >= $descontoMinimo) {
            $resultado[] = $promocao;
        }
    }

    return $resultado;
}

function mostrar($texto)
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, "UTF-8");
}
