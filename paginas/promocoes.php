<?php
include_once __DIR__ . "/../funcoes.php";

$promocoes = [
    [
        "tag" => "Combo",
        "titulo" => "2 camisetas no combo",
        "descricao" => "Promoção para comprar duas camisetas do catálogo.",
        "preco" => 159.80,
        "desconto" => 13
    ],
    [
        "tag" => "Frete",
        "titulo" => "Frete grátis acima de R$ 199",
        "descricao" => "Benefício para compras maiores.",
        "preco" => 199.00,
        "desconto" => 0
    ],
    [
        "tag" => "Desconto",
        "titulo" => "15% na coleção Crimson",
        "descricao" => "Desconto para peças selecionadas.",
        "preco" => 89.90,
        "desconto" => 15
    ]
];

$promocoesComDesconto = filtrarPromocoes($promocoes, 10);
?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Ofertas</span>
        <h1>Promoções</h1>
        <p>Promoções disponíveis na loja.</p>
    </div>
</section>

<section class="secao">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($promocoesComDesconto as $promocao) { ?>
                <?php
                    $precoOriginal = $promocao["preco"];
                    $precoComDesconto = calcularDesconto($precoOriginal, $promocao["desconto"]);
                ?>

                <div class="col-md-4">
                    <article class="card-destaque">
                        <span class="tag"><?= mostrar($promocao["tag"]); ?></span>
                        <h3><?= mostrar($promocao["titulo"]); ?></h3>
                        <p><?= mostrar($promocao["descricao"]); ?></p>

                        <p>
                            De <?= formatarPreco($precoOriginal); ?>
                            por <strong><?= formatarPreco($precoComDesconto); ?></strong>
                        </p>
                    </article>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
