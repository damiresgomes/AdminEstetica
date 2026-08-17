<?php
    if (!isset($page)) exit;

    if ($_POST) {
        //recuperar as variaveis do form
        foreach($_POST as $variavel => $valor) {
            $$variavel = $valor;
        }

        if (strlen($nome) < 5) {
            echo "<script>mensagem('Preencha o nome completo','error');</script>";
            exit;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>mensagem('Preencha o e-mail','error');</script>";
            exit;
        } else {


        if (validarCPF($cpf) != 1) {
            echo "<script>mensagem('CPF inválido','error');</script>";
            exit;
        }


        $data = explode("/", $datanascimento);
        $datanascimento = $data[2] ."-". $data[1] ."-". $data[0];

        $salario = str_replace(".", "", $salario);
        $salario = str_replace(",", ".", $salario);

        if (empty($id)) {

        $senha = password_hash($senha, PASSWORD_BCRYPT); //criptografando a senha e mudando ela

            $sql = "INSERT INTO usuario (nome, email, senha, cpf, salario, datanascimento, ativo)
                    VALUES (:nome, :email, :senha, :cpf, :salario, :datanascimento, :ativo)";
            
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":email", $email);
            $consulta->bindParam(":senha", $senha);
            $consulta->bindParam(":cpf", $cpf);
            $consulta->bindParam(":salario", $salario);
            $consulta->bindParam(":datanascimento", $datanascimento);
            $consulta->bindParam(":ativo", $ativo);
            
        } else if (empty($senha)) {

            $sql = "UPDATE usuario
                    SET nome = :nome,
                    email = :email,
                    cpf = :cpf,
                    salario = :salario,
                    datanascimento = :datanascimento,
                    ativo = :ativo
                    WHERE id = :id
                    LIMIT 1";

            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":email", $email);
            $consulta->bindParam(":cpf", $cpf);
            $consulta->bindParam(":salario", $salario);
            $consulta->bindParam(":datanascimento", $datanascimento);
            $consulta->bindParam(":ativo", $ativo);
            $consulta->bindParam(":id", $id);


        } else {

            $senha = password_hash($senha, PASSWORD_BCRYPT);

            $sql = "UPDATE usuario
                    SET nome = :nome,
                    email = :email,
                    cpf = :cpf,
                    salario = :salario,
                    datanascimento = :datanascimento,
                    ativo = :ativo,
                    senha = :senha
                    WHERE id = :id
                    LIMIT 1";

            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":email", $email);
            $consulta->bindParam(":cpf", $cpf);
            $consulta->bindParam(":salario", $salario);
            $consulta->bindParam(":datanascimento", $datanascimento);
            $consulta->bindParam(":ativo", $ativo);
            $consulta->bindParam(":id", $id);
            $consulta->bindParam(":senha", $senha);


        }

        if ($consulta->execute()) {
            echo "<script>mensagem('Registro Salvo','success', 'listar/usuario');</script>";
            exit;
        }

        echo "<script>mensagem('Erro ao salvar','error');</script>";
        exit;
    }
}