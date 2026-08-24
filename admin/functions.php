<?php

function redimensionarImagem($origem, $larguraMax, $alturaMax, $qualidade = 100) {

    $destino = $origem;
    if (!file_exists($origem)) {
        return false;
    }

    list($larguraOriginal, $alturaOriginal, $tipo) = getimagesize($origem);

    $proporcao = $larguraOriginal / $alturaOriginal;

    if ($larguraMax / $alturaMax > $proporcao) {
        $novaLargura = $alturaMax * $proporcao;
        $novaAltura = $alturaMax;
    } else {
        $novaLargura = $larguraMax;
        $novaAltura = $larguraMax / $proporcao;
    }

    $novaImagem = imagecreatetruecolor($novaLargura, $novaAltura);

    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $imagem = imagecreatefromjpeg($origem);
            break;
        case IMAGETYPE_PNG:
            $imagem = imagecreatefrompng($origem);

            imagealphablending($novaImagem, false);
            imagesavealpha($novaImagem, true);
            break;
        default:
            return false;
    }

    imagecopyresampled(
        $novaImagem,
        $imagem,
        0, 0, 0, 0,
        $novaLargura, $novaAltura,
        $larguraOriginal, $alturaOriginal
    );

    switch ($tipo) {
        case IMAGETYPE_JPEG:
            imagejpeg($novaImagem, $destino, $qualidade);
            break;
        case IMAGETYPE_PNG:
            imagepng($novaImagem, $destino);
            break;
    }

    imagedestroy($imagem);
    imagedestroy($novaImagem);

    return true;
}

function validarCPF($cpf) {
    $cpf = preg_replace('/\D/', '', $cpf);

    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        $soma = 0;

        for ($i = 0; $i < $t; $i++) {
            $soma += $cpf[$i] * (($t + 1) - $i);
        }

        $digito = ((10 * $soma) % 11) % 10;

        if ($cpf[$t] != $digito) {
            return "CPF inválido";
        }
    }

    return true;
}