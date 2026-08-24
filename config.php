<<<<<<< HEAD
<?php
    $host = "127.0.0.1";
    $user = "britoestetica";
    $pass = "brito28045";
    $dbname = "brito_estetica";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }
=======
<?php
    $host = "127.0.0.1";
    $user = "britoestetica";
    $pass = "brito28045";
    $dbname = "brito_estetica";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }
>>>>>>> eddd8de7493f3753a1b023e2b4f2f88528d02156
?>