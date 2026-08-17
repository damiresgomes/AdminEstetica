<?php
if (!isset($page)) exit;

$id = $param[2] ?? NULL;

if (!empty($id)) {
    $sql = "SELECT *, date_format(datanascimento, '%d/%m/%Y') data
            FROM usuario
            WHERE id = :id
            LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dadosCadastro = $consulta->fetch(PDO::FETCH_OBJ);
}

$nome    = $dadosCadastro->nome ?? NULL;
$email   = $dadosCadastro->email ?? NULL;
$data    = $dadosCadastro->data ?? NULL;
$cpf     = $dadosCadastro->cpf ?? NULL;
$salario = $dadosCadastro->salario ?? NULL;
$ativo   = $dadosCadastro->ativo ?? NULL;

if (!empty($salario)) {
    $salario = number_format($salario, 2, ",", ".");
}
?>

<div class="container pt-5 pb-5">
    <div class="card shadow">
        <div class="card-header">
            <div class="float-start">
                <h2>Cadastro de Usuário</h2>
            </div>

            <div class="float-end">
                <a href="cadastrar/usuario" class="btn btn-success">
                    Novo Registro
                </a>

                <a href="listar/usuario" class="btn btn-success">
                    Listar Registros
                </a>
            </div>
        </div>
        <div class="card-body">
            <form name="formCadastro" method="post" action="salvar/usuario" data-parsley-validate>
                <div class="row">
                    <div class="col-12 col-md-1">
                        <label for="id">ID:</label>
                        <input type="text" name="id" id="id" class="form-control" readonly value="<?= $id ?>">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="nome">Nome Completo:</label>
                        <input type="text" name="nome" id="nome" class="form-control" required
                            data-parsley-required-message="Preenche este campo" placeholder="Digite seu nome completo:"
                            value="<?= $nome ?>">
                    </div>

                    <div class="col-12 col-md-5">
                        <label for="email">Seu melhor e-mail:</label>
                        <input type="email" name="email" id="email" class="form-control" required
                            data-parsley-required-message="Preenche este campo"
                            data-parsley-type-message="Digite um e-mail válido" placeholder="Digite o seu E-mail:"
                            value="<?= $email ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="senha">Digite uma senha de no mínimo 6 caracteres:</label>
                        <input type="password" name="senha" id="senha" class="form-control" required
                            data-parsley-required-message="Preenche este campo" placeholder="Digite uma senha:">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="senha2">Redigite a senha:</label>
                        <input type="password" name="senha2" id="senha2" class="form-control" required
                            data-parsley-required-message="Preenche este campo" placeholder="Redigite sua senha:"
                            data-parsley-equalto="#senha" data-parsley-equalto-message="As senhas não conferem">
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="salario">Salario:</label>
                        <input type="text" name="salario" id="salario" class="form-control" required
                            data-parsley-required-message="Preencha este campo" placeholder="Digite o seu Salário:"
                            value="<?= $salario ?>">
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="datanascimento">Data de Nascimento:</label>
                        <input type="text" name="datanascimento" id="datanascimento" class="form-control" required
                            data-parsley-required-message="Preencha este campo"
                            placeholder="Digite sua Data de Nascimento:" value="<?= $data ?>">
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="cpf">Digite seu CPF:</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" required
                            data-parsley-required-message="Preencha este campo" placeholder="Digite seu CPF:"
                            value="<?= $cpf ?>">
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="ativo">Selecione Ativo</label>
                        <select name="ativo" id="ativo" class="form-control" required
                            data-parsley-required-message="Selecione uma opção">
                            <option value="">Selecione uma Opção:</option>
                            <option value="Sim" <?= (isset($ativo) && ($ativo == 'Sim' || $ativo == 'S' || $ativo == '1')) ? 'selected' : '' ?>>Sim</option>
                            <option value="Não" <?= (isset($ativo) && ($ativo == 'Não' || $ativo == 'N' || $ativo == '0')) ? 'selected' : '' ?>>Não</option>
                        </select>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-success float-end">
                    Gravar Dados
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    var cpf = document.getElementById("cpf");
    var im = new Inputmask("999.999.999-99");
    im.mask(cpf);

    var datanascimento = document.getElementById("datanascimento");
    var im = new Inputmask("99/99/9999");
    im.mask(datanascimento);
</script>

<script>
    $(document).ready(function () {
        $('#salario').mask('000.000.000,00', {
            reverse: true
        });
    })

    <?php
    if (!empty($id)) {
        ?>
        $('#senha').removeAttr('required').parsley().reset();
        $('#senha2').removeAttr('required').parsley().reset();
        <?php
    }
    ?>
</script>