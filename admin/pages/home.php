<?php
if (!isset($page))
    exit;
?>

<div class="container">
    <header>
        <h1>Dashboard <br> <span>Estetica Automotiva</span></h1>
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
            <div class="card-label">Total de Agendamentos</div>
            <div id="card-total-agendamentos" class="card-value">Carregando...</div>
        </div>
        <div class="card card-orange">
            <div class="card-label">Total de Clientes</div>
            <div id="card-total-clientes" class="card-value">Carregando...</div>
        </div>
        <div class="card card-blue">
            <div class="card-label">Total de Serviços</div>
            <div id="card-total-servicos" class="card-value">Carregando...</div>
        </div>
        <div class="card card-green">
            <div class="card-label">Total de Usuários</div>
            <div id="card-total-usuarios" class="card-value">Carregando...</div>
        </div>
        <div class="card card-orange">
            <div class="card-label">Serviço Mais Vendido</div>
            <div id="card-mais-vendido" class="card-value">Carregando...</div>
            <div id="card-total-vendido" class="card-value">Carregando...</div>
        </div>
        <div class="card card-blue">
            <div class="card-label">Agendamentos Confirmados</div>
            <div id="card-agendamentos-confirmados" class="card-value">Carregando...</div>
        </div>

        <div class="card card-green">
            <div class="card-label">Agendamentos Pendentes</div>
            <div id="card-agendamentos-pendentes" class="card-value">Carregando...</div>
        </div>

        <div class="card card-orange">
            <div class="card-label">Agendamento Cancelados</div>
            <div id="card-agendamentos-cancelados" class="card-value">Carregando...</div>
        </div>
    </div>

    <div class="tabela-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">AGENDAMENTOS RECENTES</h5>

            <div style="max-width: 300px; width: 100%;">
                <input type="text" id="input-busca" class="form-control" placeholder="Buscar por cliente ou veículo...">
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Servico</th>
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