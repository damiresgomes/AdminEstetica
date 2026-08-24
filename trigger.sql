DELIMITER //

CREATE TRIGGER trg_nome_servico_uppercase
BEFORE INSERT ON servicos
FOR EACH ROW
BEGIN
    SET NEW.nome_servico = UPPER(NEW.nome_servico);
END;
//

DELIMITER ;

/*A Trigger trg_nome_servico_uppercase monitora a tabela servicos,
antes de salvar qualquer novo registro, ela pega o texto digitado no campo nome_servico e aplica a função UPPER(),
convertendo todas as letras para MAIÚSCULAS.


ONDE ELA FAZ ISSO:
Ela roda exclusivamente dentro do próprio servidor MySQL, de forma 100% independente do PHP.
O usuário digita "lavagem" e o PHP envia a query INSERT normalmente para o banco, Assim que a instrução chega na tabela servicos,
o MySQL intercepta o comando no estágio BEFORE INSERT (antes de gravar no disco).

A Trigger altera a variável temporária NEW.nome_servico de "lavagem" para "LAVAGEM" e o MySQL salva a linha na tabela com o valor já transformado.*/