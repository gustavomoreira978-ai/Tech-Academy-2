<?php
$paginasPermitidas = [
    "home" => "paginas/home.php",
    "camisetas" => "paginas/camisetas.php",
    "promocoes" => "paginas/promocoes.php",
    "sobre" => "paginas/sobre.php",
    "contato" => "paginas/contato.php"
];

$pagina = $_GET["param"] ?? "home";
$pagina = strtolower($pagina);

if (!array_key_exists($pagina, $paginasPermitidas)) {
    $pagina = "erro";
    $arquivo = "paginas/erro.php";
} else {
    $arquivo = $paginasPermitidas[$pagina];
}

function ativo($nomePagina, $paginaAtual)
{
    if ($nomePagina == $paginaAtual) {
        return " active";
    }

    return "";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Crimson Otaku: camisetas geek, anime e gamer.">
    <title>Crimson Otaku</title>

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

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="menuPrincipal">
                    <ul class="navbar-nav ms-auto header-nav">
                        <li class="nav-item">
                            <a class="nav-link<?= ativo("home", $pagina); ?>" href="index.php?param=home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= ativo("camisetas", $pagina); ?>" href="index.php?param=camisetas">Camisetas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= ativo("promocoes", $pagina); ?>" href="index.php?param=promocoes">Promoções</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= ativo("sobre", $pagina); ?>" href="index.php?param=sobre">Sobre</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= ativo("contato", $pagina); ?>" href="index.php?param=contato">Contato</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <?php include $arquivo; ?>
    </main>

    <footer class="footer">
        <div class="container">
            <h3>CRIMSON OTAKU</h3>
            <p>Camisetas Geek, Anime e Gamer</p>
            <p>&copy; 2026 - Todos os direitos reservados</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
