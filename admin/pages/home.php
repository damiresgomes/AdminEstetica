<?php
if (!isset($page))
    exit;
?>

<div class="container">
    <header>
        <h1>Dashboard <span class="da">da</span> <br> <span>Estetica Automotiva</span></h1>
        <p>Visão geral de agendamentos, serviços e cadastros</p>
    </header>

    <div class="botoes-grid">
        <a href="cadastrar/categoria" class="btn-1" style="background-color: #5CB3FF;">+ Cadastrar Categoria</a>
        <a href="cadastrar/servicos" class="btn-2" style="background-color: #30d46c;">+ Cadastrar Serviço</a>
        <a href="cadastrar/usuario" class="btn-3" style="background-color: #ffc107;">+ Cadastrar Usuário</a>
    </div>

    <div class="cards-grid">
        
        <div class="card card-blue">
            <div class="card-label">Receita Total</div>
            <div id="card-total-total" class="card-value">Carregando...</div>
        </div>
        <div class="card card-green">
            <div class="card-label">Agendamentos</div>
            <div id="card-total-agendamentos" class="card-value">Carregando...</div>
        </div>
        <div class="card card-orange">
            <div class="card-label">Clientes</div>
            <div id="card-total-clientes" class="card-value">Carregando...</div>
        </div>
        <div class="card card-blue">
            <div class="card-label">Serviços</div>
            <div id="card-total-servicos" class="card-value">Carregando...</div>
        </div>
        <div class="card card-green">
            <div class="card-label">Usuários</div>
            <div id="card-total-usuarios" class="card-value">Carregando...</div>
        </div>
        <div class="card card-orange">
            <div class="card-label">Contato</div>
            <div id="card-total-contatos" class="card-value">Carregando...</div>
        </div>
    </div>

    <div class="tabela-container">
        <h2 class="tabela-titulo">Agendamentos Recentes</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Veículo</th>
                    <th>Placa</th>
                    <th>Data / Hora</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tabela-agendamentos-body">
            </tbody>
        </table>
    </div>

</div>

<script src="../dist/app.js"></script>