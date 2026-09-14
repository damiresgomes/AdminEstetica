<?php
session_start();

require "../config.php";
require "functions.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Administrativo - Estética</title>

    <base href="http://<?= $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"] ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../src/css/style.css">

    <link rel="icon" href="../imgs/imagens/icone.png">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/parsley.min.js"></script>
    <script src="js/sweetalert2.js"></script>
    <script src="js/bindings/inputmask.binding.js"></script>
    <script src="js/jquery.inputmask.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="css/summernote-bs5.min.css" rel="stylesheet">
    <script src="js/summernote-bs5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        function mensagem(mensagem, tipo, link = null) {
            Swal.fire({
                icon: tipo,
                title: mensagem,
                confirmButtonText: "OK",
            }).then((result) => {
                if (tipo == "error") history.back();
                else location.href = link;
            });
        }
    </script>
</head>

<body>
    <?php
    if ((!isset($_SESSION["brito_estetica"])) && ($_POST)) {

        $email = trim($_POST["email"] ?? NULL);
        $senha = trim($_POST["senha"] ?? NULL);


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>mensagem('E-mail inválido','error');</script>";
            exit;
        } else if (empty($senha)) {
            echo "<script>mensagem('Senha inválida','error');</script>";
            exit;
        }

        $sqlLogin = "SELECT id, nome, email, senha
                    FROM usuario
                    WHERE ativo = 'Sim'
                    AND email = :email 
                    limit 1";

        $consultaLogin = $pdo->prepare($sqlLogin);
        $consultaLogin->bindParam(":email", $email);
        $consultaLogin->execute();

        $dadosLogin = $consultaLogin->fetch(PDO::FETCH_OBJ);
    
        if (empty($dadosLogin->id)) {
            echo "<script>mensagem('Login inválido','error');</script>";
            exit;
        } else if (!password_verify($senha, $dadosLogin->senha)) {
            echo "<script>mensagem('Login inválido','error');</script>";
            exit;
        }

        $_SESSION["brito_estetica"] = array(
            "id" => $dadosLogin->id,
            "nome" => $dadosLogin->nome
        );

        echo "<script>location.href='index.php';</script>";

    } else if (!isset($_SESSION["brito_estetica"])) {
        require "pages/login.php";
    } else {
        ?>
            <nav class="navbar navbar-expand-lg bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        BRITO <span class="brand-gold">ESTÉTICA</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="cadastrar/categoria">Categoria</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="cadastrar/servicos">Serviços</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="cadastrar/usuario">Usuário</a>
                            </li>
                        </ul>
                        <div class="d-flex">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Olá <?= $_SESSION["brito_estetica"]["nome"] ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="sair.php">Sair</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <main>
                <?php
                $param = $_GET["param"] ?? "pages/home";
                $param = explode("/", $param);

                $c = count($param);

                if ($c == 1) $page = "pages/{$param[0]}.php";
                else $page = "{$param[0]}/{$param[1]}.php";

                $id = $param[2] ?? NULL;

                if (file_exists($page)) require $page;
                else require "pages/erro.php";

                ?>
            </main>
            <footer class="bg-dark text-center p-3">
                <p>Desenvolvido por Damires | Sistema Administrativo</p>
            </footer>
        <?php
    }
?>
</body>
</html>