<?php
include_once __DIR__ . "/../conexao.php";
include_once __DIR__ . "/../funcoes.php";

$categoriasMarcadas = $_GET["categoria"] ?? [];
$tamanhosMarcados = $_GET["tamanho"] ?? [];

if (!is_array($categoriasMarcadas)) {
    $categoriasMarcadas = [];
}

if (!is_array($tamanhosMarcados)) {
    $tamanhosMarcados = [];
}

$categorias = [];
$resultadoCategorias = mysqli_query($conn, "SELECT nome FROM categorias ORDER BY nome");

while ($linha = mysqli_fetch_assoc($resultadoCategorias)) {
    $categorias[] = $linha["nome"];
}

$sql = "SELECT camisetas.* FROM camisetas INNER JOIN categorias ON camisetas.categoria_id = categorias.id";
$condicoes = ["camisetas.ativo = 1"];

if (count($categoriasMarcadas) > 0) {
    $lista = [];

    foreach ($categoriasMarcadas as $categoria) {
        $lista[] = "'" . mysqli_real_escape_string($conn, $categoria) . "'";
    }

    $condicoes[] = "categorias.nome IN (" . implode(",", $lista) . ")";
}

if (count($tamanhosMarcados) > 0) {
    $listaTamanhos = [];

    foreach ($tamanhosMarcados as $tamanho) {
        $tamanho = mysqli_real_escape_string($conn, $tamanho);
        $listaTamanhos[] = "camisetas.tamanho LIKE '%" . $tamanho . "%'";
    }

    $condicoes[] = "(" . implode(" OR ", $listaTamanhos) . ")";
}

$sql .= " WHERE " . implode(" AND ", $condicoes);
$sql .= " ORDER BY camisetas.id DESC";

$resultado = mysqli_query($conn, $sql);
?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Catálogo</span>
        <h1>Camisetas</h1>
        <p>Produtos cadastrados no banco de dados da loja.</p>
    </div>
</section>

<div class="layout-loja">
    <aside class="filtros">
        <h3>Filtros</h3>

        <form method="GET" action="index.php">
            <input type="hidden" name="param" value="camisetas">

            <div class="filtro-grupo">
                <h4>Categoria</h4>

                <?php foreach ($categorias as $categoria) { ?>
                    <label>
                        <input
                            type="checkbox"
                            name="categoria[]"
                            value="<?= mostrar($categoria); ?>"
                            <?= in_array($categoria, $categoriasMarcadas) ? "checked" : ""; ?>>
                        <?= mostrar($categoria); ?>
                    </label>
                <?php } ?>
            </div>

            <div class="filtro-grupo">
                <h4>Tamanho</h4>

                <?php foreach (["P", "M", "G", "GG"] as $tamanho) { ?>
                    <label>
                        <input
                            type="checkbox"
                            name="tamanho[]"
                            value="<?= $tamanho; ?>"
                            <?= in_array($tamanho, $tamanhosMarcados) ? "checked" : ""; ?>>
                        <?= $tamanho; ?>
                    </label>
                <?php } ?>
            </div>

            <button class="btn btn-geek w-100 mt-3" type="submit">Filtrar</button>
            <a class="btn btn-outline-geek w-100 mt-2" href="index.php?param=camisetas">Limpar</a>
        </form>
    </aside>

    <section class="produtos">
        <?php if ($resultado && mysqli_num_rows($resultado) > 0) { ?>
            <?php while ($camiseta = mysqli_fetch_assoc($resultado)) { ?>
                <a class="produto-link" href="produto.php?id=<?= $camiseta["id"]; ?>">
                    <article class="produto">
                        <div class="img-container">
                            <img src="imagens/<?= mostrar(trim($camiseta["imagem"])); ?>" alt="<?= mostrar($camiseta["nome"]); ?>">
                        </div>

                        <?php if (!empty($camiseta["imagem2"])) { ?>
                            <div class="mini-preview">
                                <img src="imagens/<?= mostrar(trim($camiseta["imagem2"])); ?>" alt="Segunda imagem">
                            </div>
                        <?php } ?>

                        <div class="produto-corpo">
                            <h3><?= mostrar($camiseta["nome"]); ?></h3>
                            <p><?= mostrar($camiseta["descricao"]); ?></p>

                            <span class="preco">
                                <?= formatarPreco($camiseta["preco"]); ?>
                            </span>

                            <span class="btn-comprar">Ver detalhes</span>
                        </div>
                    </article>
                </a>
            <?php } ?>
        <?php } else { ?>
            <div class="estado-vazio">
                <h2>Nenhum produto encontrado</h2>
                <p>Tente limpar os filtros ou escolha outra opção.</p>
            </div>
        <?php } ?>
    </section>
</div>
