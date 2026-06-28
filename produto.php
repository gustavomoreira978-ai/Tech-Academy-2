<?php
include "conexao.php";
include "funcoes.php";

$id = $_GET["id"] ?? 0;
$id = intval($id);

$produto = null;

if ($id > 0) {
    $sql = "SELECT * FROM camisetas WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);
    $produto = mysqli_fetch_assoc($resultado);
}

if ($produto) {
    $precoProduto = (float) $produto["preco"];
    $precoComDesconto = calcularDesconto($precoProduto, 10);
    $frete = calcularFrete($precoProduto);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto | Crimson Otaku</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=20260628">
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container header-container">
                <a href="index.php?param=home" class="navbar-brand header-logo">
                    <img src="imagens/image2.png" alt="Crimson Otaku">
                </a>

                <a class="btn btn-outline-geek btn-sm" href="index.php?param=camisetas">
                    Voltar ao catálogo
                </a>
            </div>
        </nav>
    </header>

    <main>
        <?php if (!$produto) { ?>
            <section class="page-hero">
                <div class="container">
                    <span class="eyebrow">Erro</span>
                    <h1>Produto não encontrado</h1>
                    <p>Não foi possível encontrar esse produto no banco de dados.</p>
                    <a class="btn btn-geek" href="index.php?param=camisetas">Ver camisetas</a>
                </div>
            </section>
        <?php } else { ?>

            <section class="produto-showcase">
                <div class="container">
                    <div class="produto-breadcrumb">
                        <a href="index.php?param=home">Home</a>
                        <span>/</span>
                        <a href="index.php?param=camisetas">Camisetas</a>
                        <span>/</span>
                        <strong><?= mostrar($produto["nome"]); ?></strong>
                    </div>

                    <div class="produto-compra">
                        <div class="produto-galeria">
                            <div class="thumbs-produto">
                                <button class="thumb-produto active" type="button" data-image="imagens/<?= mostrar(trim($produto["imagem"])); ?>">
                                    <img src="imagens/<?= mostrar(trim($produto["imagem"])); ?>" alt="Imagem principal">
                                </button>

                                <?php if (!empty($produto["imagem2"])) { ?>
                                    <button class="thumb-produto" type="button" data-image="imagens/<?= mostrar(trim($produto["imagem2"])); ?>">
                                        <img src="imagens/<?= mostrar(trim($produto["imagem2"])); ?>" alt="Segunda imagem">
                                    </button>
                                <?php } ?>
                            </div>

                            <button class="imagem-produto-grande" type="button" data-bs-toggle="modal" data-bs-target="#fotoProduto">
                                <img id="imagemProdutoPrincipal" src="imagens/<?= mostrar(trim($produto["imagem"])); ?>" alt="<?= mostrar($produto["nome"]); ?>">
                                <span>Clique para ampliar</span>
                            </button>
                        </div>

                        <div class="produto-painel">
                            <span class="produto-status">Produto novo</span>

                            <h1><?= mostrar($produto["nome"]); ?></h1>

                            <div class="preco-produto">
                                <small>Preço</small>
                                <strong><?= formatarPreco($precoProduto); ?></strong>
                                <span>Com 10% de desconto: <?= formatarPreco($precoComDesconto); ?></span>
                                <span>Frete calculado: <?= formatarPreco($frete); ?></span>
                            </div>

                            <div class="bloco-opcao">
                                <div class="opcao-cabecalho">
                                    <strong>Tamanho</strong>
                                    <small>Escolha uma opção</small>
                                </div>

                                <div class="tamanhos-produto">
                                    <label><input type="radio" name="tamanho" checked><span>P</span></label>
                                    <label><input type="radio" name="tamanho"><span>M</span></label>
                                    <label><input type="radio" name="tamanho"><span>G</span></label>
                                    <label><input type="radio" name="tamanho"><span>GG</span></label>
                                </div>
                            </div>

                            <div class="bloco-opcao">
                                <div class="opcao-cabecalho">
                                    <strong>Quantidade</strong>
                                    <small>Escolha a quantidade</small>
                                </div>

                                <select class="form-select bg-dark text-white border-secondary">
                                    <option>1 unidade</option>
                                    <option>2 unidades</option>
                                    <option>3 unidades</option>
                                </select>
                            </div>

                            <div class="produto-acoes">
                                <button class="btn btn-geek btn-lg" type="button">Comprar agora</button>
                                <button class="btn btn-outline-geek btn-lg" type="button">Adicionar ao carrinho</button>
                            </div>
                        </div>
                    </div>

                    <section class="produto-descricao-box">
                        <h2>Informações da peça</h2>
                        <p><?= mostrar($produto["descricao"]); ?></p>

                        <div class="info-grid-produto">
                            <div>
                                <strong>Tamanhos</strong>
                                <span><?= mostrar($produto["tamanho"]); ?></span>
                            </div>
                            <div>
                                <strong>Estoque</strong>
                                <span><?= mostrar($produto["estoque"]); ?> unidades</span>
                            </div>
                            <div>
                                <strong>Categoria</strong>
                                <span>Camiseta geek/anime</span>
                            </div>
                        </div>
                    </section>
                </div>
            </section>

            <div class="modal fade modal-produto" id="fotoProduto" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title"><?= mostrar($produto["nome"]); ?></h2>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <img id="imagemProdutoModal" src="imagens/<?= mostrar(trim($produto["imagem"])); ?>" alt="<?= mostrar($produto["nome"]); ?>">
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/produto.js?v=20260628"></script>
</body>

</html>
