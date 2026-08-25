-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/08/2026 às 14:57
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `brito_estetica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id_agendamento` int(11) NOT NULL,
  `data_hora` datetime NOT NULL,
  `placa_veiculo` varchar(10) DEFAULT NULL,
  `modelo_veiculo` varchar(50) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  `status` enum('Pendente','Confirmado','Cancelado') NOT NULL DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id_agendamento`, `data_hora`, `placa_veiculo`, `modelo_veiculo`, `id_cliente`, `status`) VALUES
(101, '2026-06-24 09:00:00', 'ABC-1234', 'VW Golf', 1, 'Confirmado'),
(102, '2026-06-24 14:00:00', 'XYZ-5678', 'Honda Civic', 2, 'Confirmado'),
(103, '2026-06-25 08:30:00', 'KIL-9012', 'BMW 320i', 3, 'Confirmado'),
(104, '2026-06-25 13:00:00', 'MNO-3456', 'Hyundai HB20', 4, 'Confirmado'),
(105, '2026-06-26 10:00:00', 'QWE-7890', 'Toyota Corolla', 5, 'Confirmado'),
(106, '2026-06-27 09:00:00', 'ABC-1234', 'VW Golf', 1, 'Pendente'),
(107, '2026-06-25 09:00:00', 'DEX-4591', 'Jeep Compass', 6, 'Pendente'),
(108, '2026-06-25 14:00:00', 'EGA-8233', 'Honda HR-V', 7, 'Pendente'),
(109, '2026-06-26 08:00:00', 'FTY-1029', 'Chevrolet Onix', 8, 'Pendente'),
(110, '2026-06-26 13:30:00', 'BRL-5544', 'BMW M3', 9, 'Pendente'),
(111, '2026-06-27 08:30:00', 'GHT-7711', 'Fiat Toro', 10, 'Pendente'),
(112, '2026-06-27 10:30:00', 'KND-3920', 'Toyota Hilux', 11, 'Pendente'),
(113, '2026-06-27 14:00:00', 'MXC-8822', 'Hyundai Creta', 12, 'Pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento_servico`
--

CREATE TABLE `agendamento_servico` (
  `id_agendamento` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamento_servico`
--

INSERT INTO `agendamento_servico` (`id_agendamento`, `id_servico`) VALUES
(101, 1),
(101, 9),
(102, 4),
(102, 12),
(103, 5),
(103, 6),
(103, 11),
(104, 2),
(105, 1),
(105, 14),
(106, 3),
(107, 2),
(107, 11),
(108, 1),
(108, 12),
(109, 4),
(109, 7),
(110, 5),
(110, 6),
(111, 1),
(111, 8),
(112, 3),
(112, 13),
(113, 1),
(113, 14);

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nome_categoria`) VALUES
(1, 'principal'),
(2, 'extra');

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome`, `telefone`) VALUES
(1, 'Carlos Santos', '(19) 98888-0001'),
(2, 'Ana Rodrigues', '(19) 97777-0002'),
(3, 'Bruno Oliveira', '(19) 96666-0003'),
(4, 'Mariana Costa', '(19) 95555-0004'),
(5, 'Pedro Almeida', '(19) 94444-0005'),
(6, 'Fernanda Linhares', '(19) 98111-2233'),
(7, 'Gabriel Zanetti', '(19) 98765-4321'),
(8, 'Juliana Paschoal', '(19) 99234-5678'),
(9, 'Rodrigo Prado', '(19) 99100-1122'),
(10, 'Letícia Camargo', '(19) 98877-6655'),
(11, 'Matheus Aranha', '(19) 99345-6789'),
(12, 'Camila Rezende', '(19) 98222-3344');

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id_servico` int(11) NOT NULL,
  `nome_servico` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `duracao_horas` decimal(4,2) NOT NULL DEFAULT 0.00,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`id_servico`, `nome_servico`, `descricao`, `preco`, `duracao_horas`, `id_categoria`) VALUES
(1, 'LAVAGEM DETALHADA', 'Uma limpeza externa completa com secagem manual, vidros limpos e acabamento nos pneus. Ideal para\r\n                    quem usa o carro diariamente e quer manter a aparência sempre impecável sem gastar muito tempo.', 9000.00, 3.00, 1),
(2, 'Higienização Interna Completa', 'Serviço premium que cuida do interior do veículo: aspiração profunda, limpeza de painel, portas e vidros, além de aromatização. Indicado para quem deseja eliminar poeira, ácaros e odores, deixando o carro com aspecto de novo.', 1200.00, 7.00, 1),
(3, 'Restauração de Faróis', 'Recupera a transparência dos faróis, removendo opacidade e pequenos riscos. Inclui polimento, aplicação de cera e proteção UV. Melhora a estética e aumenta a segurança à noite.', 250.00, 3.00, 1),
(4, 'Polimento Comercial', 'Corrige arranhões leves e devolve brilho à pintura. A cristalização protege contra desgaste e o tratamento UV prolonga a vida da pintura. É uma opção intermediária para quem quer renovar o visual sem investir em polimento técnico.', 700.00, 6.00, 1),
(5, 'Limpeza de Motor', 'Limpeza cuidadosa do compartimento do motor, removendo sujeira e oleosidade sem danificar componentes elétricos. Inclui proteção UV e cristalização da pintura. Além da estética, ajuda na manutenção preventiva.', 400.00, 4.00, 1),
(6, 'Polimento Técnico + Vitrificação', 'Processo avançado que corrige microarranhões e imperfeições da pintura. Finalizado com vitrificação cerâmica, que cria uma camada protetora contra sol, chuva e sujeira. É o serviço mais indicado para carros novos ou de luxo.', 2500.00, 11.00, 1),
(7, 'Vitrificação de Plástico', 'Tratamento que protege plásticos internos e externos contra ressecamento e desbotamento. Mantém a textura original e dá aspecto renovado às peças.', 700.00, 3.50, 1),
(8, 'Limpeza de Chassi', 'Limpeza profunda da parte inferior do veículo, removendo barro, óleo e resíduos. Inclui proteção anticorrosiva, essencial para quem roda em estradas de terra ou regiões úmidas.', 500.00, 4.00, 1),
(9, 'Higienização dos Bancos', 'Limpeza completa dos bancos em tecido ou couro, removendo manchas e odores. No couro, inclui hidratação para evitar rachaduras. Garante conforto e preserva o valor do veículo.', 800.00, 6.00, 1),
(10, 'Polimento Técnico', 'Polimento detalhado para correção de riscos leves.', 200.00, 5.00, 2),
(11, 'Hidratação de Couro', 'Tratamento para manter o couro macio e protegido.', 200.00, 2.00, 2),
(12, 'Cristalização de Vidros', 'Aplicação de produto repelente de água nos vidros.', 200.00, 2.00, 2),
(13, 'Limpeza do Motor', 'Serviço adicional de higienização do motor.', 400.00, 2.00, 2),
(14, 'Cera Líquida', 'Aplicação rápida de cera para proteção e brilho da pintura.', 80.00, 1.00, 2),
(24, 'TESTE TRIGGER (UPPERCASE)', '<p>Testando a trigger funcionando.<br>O objetivo é ao cadastrar um novo serviço, colocar o nome em caixa alta no banco de dados.</p>', 100.00, 2.50, 1);

--
-- Acionadores `servicos`
--
DELIMITER $$
CREATE TRIGGER `trg_nome_servico_uppercase` BEFORE INSERT ON `servicos` FOR EACH ROW BEGIN
    SET NEW.nome_servico = UPPER(NEW.nome_servico);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_servicos_before_update` BEFORE UPDATE ON `servicos` FOR EACH ROW BEGIN
    SET NEW.nome_servico = UPPER(NEW.nome_servico);
    
    IF NEW.preco < 0 THEN
        SET NEW.preco = 0;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `cpf` varchar(30) NOT NULL,
  `salario` double NOT NULL,
  `datanascimento` date NOT NULL,
  `ativo` enum('Sim','Não') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `cpf`, `salario`, `datanascimento`, `ativo`) VALUES
(1, 'Administrador', 'admin@gmail.com', '$2y$10$UlRENRQON2SjaSYAxmYs4OydOa5NkiJTqdZMbKiJbH75yZ5Xfebom', '094.650.100-90', 3500, '1980-07-22', 'Sim'),
(2, 'Bill Gates', 'teste@teste.com', '$2y$10$ineMFivFCCHdP3gGGWfoR.RRqt.3jYDbIi.mXDPLjIM0vvYps9j7G', '424.454.180-20', 3500, '2000-10-20', 'Sim');

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_servico_mais_vendido`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_servico_mais_vendido` (
`nome_servico` varchar(100)
,`total_vendas` bigint(21)
);

-- --------------------------------------------------------

--
-- Estrutura para view `vw_servico_mais_vendido`
--
DROP TABLE IF EXISTS `vw_servico_mais_vendido`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_servico_mais_vendido`  AS WITH ContagemServicos AS (SELECT `s`.`nome_servico` AS `nome_servico`, count(`ags`.`id_agendamento`) AS `total_vendas` FROM (`servicos` `s` left join `agendamento_servico` `ags` on(`s`.`id_servico` = `ags`.`id_servico`)) GROUP BY `s`.`id_servico`, `s`.`nome_servico`) SELECT `contagemservicos`.`nome_servico` AS `nome_servico`, `contagemservicos`.`total_vendas` AS `total_vendas` FROM `contagemservicos` ORDER BY `contagemservicos`.`total_vendas` DESC LIMIT 0, 11  ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id_agendamento`),
  ADD KEY `fk_agendamentos_cliente` (`id_cliente`);

--
-- Índices de tabela `agendamento_servico`
--
ALTER TABLE `agendamento_servico`
  ADD PRIMARY KEY (`id_agendamento`,`id_servico`),
  ADD KEY `fk_pivo_servico` (`id_servico`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `fk_servicos_categoria` (`id_categoria`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id_agendamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `fk_agendamentos_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Restrições para tabelas `agendamento_servico`
--
ALTER TABLE `agendamento_servico`
  ADD CONSTRAINT `fk_pivo_agendamento` FOREIGN KEY (`id_agendamento`) REFERENCES `agendamentos` (`id_agendamento`),
  ADD CONSTRAINT `fk_pivo_servico` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`);

--
-- Restrições para tabelas `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `fk_servicos_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
