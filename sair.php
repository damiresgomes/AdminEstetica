<?php
    session_start();
    unset($_SESSION["brito_estetica"]);
    echo "<script>location.href='index.php'</script>";